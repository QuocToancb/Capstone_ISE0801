/*===============================================================================
Copyright (c) 2016 PTC Inc. All Rights Reserved.

Copyright (c) 2012-2014 Qualcomm Connected Experiences, Inc. All Rights Reserved.

Vuforia is a trademark of PTC Inc., registered in the United States and other 
countries.
===============================================================================*/

package com.vuforia.samples.VuforiaSamples.app.CloudRecognition;

import android.opengl.GLES20;
import android.opengl.GLSurfaceView;
import android.util.Log;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.vuforia.Renderer;
import com.vuforia.State;
import com.vuforia.TrackableResult;
import com.vuforia.VIDEO_BACKGROUND_REFLECTION;
import com.vuforia.Vuforia;
import com.vuforia.samples.SampleApplication.SampleApplicationSession;
import com.vuforia.samples.SampleApplication.utils.CubeShaders;
import com.vuforia.samples.SampleApplication.utils.SampleUtils;
import com.vuforia.samples.SampleApplication.utils.Teapot;
import com.vuforia.samples.SampleApplication.utils.Texture;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.Vector;

import javax.microedition.khronos.egl.EGLConfig;
import javax.microedition.khronos.opengles.GL10;


// The renderer class for the CloudReco sample. 
public class CloudRecoRenderer implements GLSurfaceView.Renderer {
    SampleApplicationSession vuforiaAppSession;

    private static final float OBJECT_SCALE_FLOAT = 3.0f;

    private int shaderProgramID;
    private int vertexHandle;
    private int textureCoordHandle;
    private int mvpMatrixHandle;
    private int texSampler2DHandle;

    private Vector<Texture> mTextures;

    private Teapot mTeapot;

    private CloudReco mActivity;

    //Thread to play music when a target founded
    Thread th;
    final RequestQueue queue;

    boolean isGettingData = false;
    int countRequest = 0;

    public CloudRecoRenderer(SampleApplicationSession session, CloudReco activity) {
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

        for (Texture t : mTextures) {
            GLES20.glGenTextures(1, t.mTextureID, 0);
            GLES20.glBindTexture(GLES20.GL_TEXTURE_2D, t.mTextureID[0]);
            GLES20.glTexParameterf(GLES20.GL_TEXTURE_2D,
                    GLES20.GL_TEXTURE_MIN_FILTER, GLES20.GL_LINEAR);
            GLES20.glTexParameterf(GLES20.GL_TEXTURE_2D,
                    GLES20.GL_TEXTURE_MAG_FILTER, GLES20.GL_LINEAR);
            GLES20.glTexImage2D(GLES20.GL_TEXTURE_2D, 0, GLES20.GL_RGBA,
                    t.mWidth, t.mHeight, 0, GLES20.GL_RGBA,
                    GLES20.GL_UNSIGNED_BYTE, t.mData);
        }

        shaderProgramID = SampleUtils.createProgramFromShaderSrc(
                CubeShaders.CUBE_MESH_VERTEX_SHADER,
                CubeShaders.CUBE_MESH_FRAGMENT_SHADER);

        vertexHandle = GLES20.glGetAttribLocation(shaderProgramID,
                "vertexPosition");
        textureCoordHandle = GLES20.glGetAttribLocation(shaderProgramID,
                "vertexTexCoord");
        mvpMatrixHandle = GLES20.glGetUniformLocation(shaderProgramID,
                "modelViewProjectionMatrix");
        texSampler2DHandle = GLES20.glGetUniformLocation(shaderProgramID,
                "texSampler2D");
        mTeapot = new Teapot();
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

            if (!targetName.equals(mActivity.savedObject.getTargetName())) {
                getTargetData(targetName, mActivity.museumID);
//                if (trackableResult == null) {
//                    return;
//                }


//
//            Log.d("QuocToanLog", imageTarget.getName());
//            if (mActivity.isMusicPlaying == 0) {
//
//                //Case Extend tracking
//
//                if (!nameTargetNew.equals(nameTarget)) {
//                    nameTarget = nameTargetNew;
//                    mActivity.stop();
////                if (isplaying) {
////                    th.interrupt();
////                }
//                    th = new Thread(new Runnable() {
//                        public void run() {
//
//                            mActivity.playNew("http://s1mp3.hot1.cache31.vcdn.vn/9b74df404504ac5af515/4402411033256464493?key=uZMKShPlJGhPA8FvxQ3OGA&expires=1480200257&filename=Ho%20Guom%20Sang%20Som%20-%20Hoang%20Hai.mp3");
//
//
//                        }
//                    });
//                    th.start();
//
//                    mActivity.isplaying = true;
//                } else if (!mActivity.isplaying) {
//                    mActivity.mediaPlayer.start();
//                    mActivity.isplaying = true;
//                }
//
//            } else if (mActivity.isMusicPlaying == 1) {
//                if (!nameTargetNew.equals(nameTarget)) {
//                    nameTarget = nameTargetNew;
//                } else {
//                    Intent mPlayerHelperActivityIntent = new Intent(mActivity, FullscreenPlayback.class);
//                    mPlayerHelperActivityIntent
//                            .setAction(Intent.ACTION_VIEW);
//                    mPlayerHelperActivityIntent.putExtra(
//                            "shouldPlayImmediately", true);
//                    mPlayerHelperActivityIntent.putExtra("currentSeekPosition",
//                            0);
//                    mPlayerHelperActivityIntent.putExtra("requestedOrientation",
//                            ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
//                    mActivity.startActivityForResult(mPlayerHelperActivityIntent, 1);
//                }
//            }

            }
        } else {
            isGettingData = false;
            mActivity.startFinderIfStopped();
        }

        GLES20.glDisable(GLES20.GL_DEPTH_TEST);

        Renderer.getInstance().end();
    }


    public void setTextures(Vector<Texture> textures) {
        mTextures = textures;
    }


    public void getTargetData(final String targetName, int museumId) {
        // Instantiate the RequestQueue.
//        final RequestQueue queue = Volley.newRequestQueue(mActivity);
        if (isGettingData) {
            mActivity.stopFinderIfStarted();
            return;
        }
        isGettingData = true;
        String url = "http://friendlyguider.com/museum/index.php/main/server?getContent&museumid=" + museumId + "&targetname=" + targetName + "&format=json";
        Log.d("stringRequest", url);
        countRequest++;
        Log.d("count", String.valueOf(countRequest));
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        JSONArray jsonArray = null;
                        try {
                            Log.d("jsonStringResponse", response);
                            jsonArray = (new JSONObject(response)).getJSONArray("object");
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        try {
                            String audioLink = "http://friendlyguider.com/museum/" + jsonArray.getJSONObject(0).getString("audio");
                            String videoLink = "http://friendlyguider.com/museum/" + jsonArray.getJSONObject(0).getString("video");
                            setNewObjectData(new DataObject(targetName, audioLink, videoLink));
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

//                        setNewObjectData(new DataObject(targetName, "http://s1mp3.hot1.cache31.vcdn.vn/9b74df404504ac5af515/4402411033256464493?key=uZMKShPlJGhPA8FvxQ3OGA&expires=1480200257&filename=Ho%20Guom%20Sang%20Som%20-%20Hoang%20Hai.mp3", ""));

                        mActivity.stopFinderIfStarted();

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.d("AAAA", "Lỗi getJSONObjectFromURL" + error.getMessage());
                queue.getCache().clear();
            }

        });
// Add the request to the RequestQueue.
        queue.add(stringRequest);
        queue.getSequenceNumber();
    }

    public void setNewObjectData(DataObject newObject) {

        mActivity.savedObject = newObject;
    }
}
