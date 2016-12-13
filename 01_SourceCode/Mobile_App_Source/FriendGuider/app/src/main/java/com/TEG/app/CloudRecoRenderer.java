
package com.TEG.app;


import android.opengl.GLES20;
import android.opengl.GLSurfaceView;
import android.util.Log;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.NetworkError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.vuforia.Renderer;
import com.vuforia.State;
import com.vuforia.TrackableResult;
import com.vuforia.VIDEO_BACKGROUND_REFLECTION;
import com.vuforia.Vuforia;
import com.TEG.utils.ApplicationSession;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import javax.microedition.khronos.egl.EGLConfig;
import javax.microedition.khronos.opengles.GL10;


// The renderer class for the CloudReco sample.
class CloudRecoRenderer implements GLSurfaceView.Renderer {
    private ApplicationSession vuforiaAppSession;


    private CloudReco mActivity;

    private final RequestQueue queue;

    private boolean isGettingData = false;

    private boolean isCurentObDisable;

    CloudRecoRenderer(ApplicationSession session, CloudReco activity) {
        vuforiaAppSession = session;
        mActivity = activity;
        queue = Volley.newRequestQueue(mActivity);
    }


    // Called when the surface is created or recreated.
    @Override
    public void onSurfaceCreated(GL10 gl, EGLConfig config) {
        // Call function to initialize rendering:
        initRendering();

        // Call Vuforia function to (re)initialize rendering after first use
        // or after OpenGL ES context was lost (e.g. after onPause/onResume):
        vuforiaAppSession.onSurfaceCreated();
    }


    // Called when the surface changed size.
    @Override
    public void onSurfaceChanged(GL10 gl, int width, int height) {
        // Call Vuforia function to handle render surface size changes:
        vuforiaAppSession.onSurfaceChanged(width, height);
    }


    // Called to draw the current frame.
    @Override
    public void onDrawFrame(GL10 gl) {
        // Call our function to render content
        renderFrame();
    }


    // Function for initializing the renderer.
    private void initRendering() {
        // Define clear color
        GLES20.glClearColor(0.0f, 0.0f, 0.0f, Vuforia.requiresAlpha() ? 0.0f
                : 1.0f);


    }


    // The render function.
    private void renderFrame() {
        // Clear color and depth buffer
        GLES20.glClear(GLES20.GL_COLOR_BUFFER_BIT | GLES20.GL_DEPTH_BUFFER_BIT);

        // Get the state from Vuforia and mark the beginning of a rendering
        // section
        State state = Renderer.getInstance().begin();

        // Explicitly render the Video Background
        Renderer.getInstance().drawVideoBackground();

        GLES20.glEnable(GLES20.GL_DEPTH_TEST);
        GLES20.glEnable(GLES20.GL_CULL_FACE);
        if (Renderer.getInstance().getVideoBackgroundConfig().getReflection() == VIDEO_BACKGROUND_REFLECTION.VIDEO_BACKGROUND_REFLECTION_ON)
            GLES20.glFrontFace(GLES20.GL_CW);  // Front camera
        else
            GLES20.glFrontFace(GLES20.GL_CCW);   // Back camera

        // Set the viewport
        int[] viewport = vuforiaAppSession.getViewport();
        GLES20.glViewport(viewport[0], viewport[1], viewport[2], viewport[3]);

        // Did we find any trackables this frame?
        if (state.getNumTrackableResults() > 0) {
            // Gets current trackable result
            TrackableResult trackableResult = state.getTrackableResult(0);
            String targetName = trackableResult.getTrackable().getName();
            //is new object difference with saved object and enable?
            if (!targetName.equals(mActivity.savedObject.getTargetName()) || isCurentObDisable) {
                getTargetData(targetName, mActivity.museumID);
//

                // is saved object had been enable?
            } else {
                mActivity.stopFinderIfStarted();
            }
        } else {
            isGettingData = false;
            mActivity.startFinderIfStopped();
        }

        GLES20.glDisable(GLES20.GL_DEPTH_TEST);

        Renderer.getInstance().end();
    }


    private void getTargetData(final String targetName, int museumId) {
        // Instantiate the RequestQueue.
        if (isGettingData) {
            return;
        }
        isGettingData = true;
        String url = "http://friendlyguider.com/museum/index.php/main/server?getContent&museumid=" + museumId + "&targetname=" + targetName + "&format=json";
        Log.d("CloudRecoRenderer", "StringRequest: " + url);
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        boolean isResponseError = false;
                        Log.d("CloudRecoRenderer", "Data Response: " + response);
                        JSONObject jsonObject = null;
                        JSONArray jsonArray = null;
                        try {
                            jsonObject = new JSONObject(response);
                            jsonArray = jsonObject.getJSONArray("object");
                        } catch (JSONException e) {
                            isResponseError = true;
                            mActivity.showErrorMessageJson("Dữ liệu JSON trả về lỗi", e.getMessage(), false);
                        }
                        if (!isResponseError) {
                            try {
                                //Get data sucess
                                if (jsonObject.get("status").equals("success")) {
                                    isCurentObDisable = false;
                                    String audioPath = jsonArray.getJSONObject(0).getString("audio");
                                    String audioLink;
                                    String videoPath = jsonArray.getJSONObject(0).getString("video");
                                    String videoLink;
                                    if (audioPath.compareTo("") == 0) {
                                        audioLink = "";
                                    } else {
                                        audioLink = "http://friendlyguider.com/museum/" + audioPath;
                                    }

                                    if (videoPath.compareTo("") == 0) {
                                        videoLink = "";
                                    } else {
                                        videoLink = "http://friendlyguider.com/museum/" + videoPath;
                                    }

                                    setNewObjectData(new DataObject(targetName, audioLink, videoLink));
                                    mActivity.stopFinderIfStarted();
                                } else if (jsonObject.get("status").equals("nodata")) {
                                    mActivity.showErrorMessageJson("Chọn sai bảo tàng", "Bảo tàng bạn đã chọn không chính xác với nơi bạn đang tham quan \nXin vui lòng lựa chọn lại", false);
                                } else if (jsonObject.get("status").equals("deactived")) {
                                    mActivity.showErrorMessageJson("Hiện vật đang khóa", "Dữ liệu của hiện vật đang được sửa đổi \nXin quý khác vui lòng quay lại sau", false);
                                    isCurentObDisable = true;
                                    setNewObjectData(new DataObject(targetName));
                                } else {
                                    //TODO
                                    mActivity.showErrorMessageJson("Chưa xác định trạng thái", "Hiên vật đang không khả dụng \nVui lòng thử lại sau.", false);
                                }
                            } catch (JSONException e) {
                                mActivity.showErrorMessageJson("Xảy ra lỗi", "Có lỗi trong quá trình lấy dữ liệu từ Json", false);
                                Log.d("CloudRecoRenderer", "Get status: " + e.getMessage());
                            }
                        }

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.d("CloudRecoRenderer", "Lỗi getJSONObjectFromURL" + error.getMessage());
                String message;
                if (error instanceof NetworkError) {
                    message = "Không thể kết nối đến internet... Vui lòng kiểm tra lại kết nối!";
                } else if (error instanceof ServerError) {
                    message = "Không thể kết nối với máy chủ. Vui lòng thử lại sau!";
                } else if (error instanceof AuthFailureError) {
                    message = "Không thể kết nối đến internet... Vui lòng kiểm tra lại kết nối!";
                } else if (error instanceof TimeoutError) {
                    message = "Kết nối bị gián đoạn! Vui lòng kiểm tra lại kết nối!.";
                } else {
                    message = "Không thể kết nối đến internet... Vui lòng kiểm tra lại kết nối!";
                }

                mActivity.showErrorMessageJson("Có lỗi trong quá trình lấy dữ liệu", message, true);
            }

        });
        //set no Cahe for htto request
        stringRequest.setShouldCache(false);

        //settime out for http request
        stringRequest.setRetryPolicy(new DefaultRetryPolicy(
                500,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        // Add the request to the RequestQueue.
        queue.add(stringRequest);
    }

    private void setNewObjectData(DataObject newObject) {

        mActivity.savedObject = newObject;
    }
}
