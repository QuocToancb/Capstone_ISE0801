

package com.TEG.app;

import android.app.AlertDialog;
import android.app.ListActivity;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ArrayAdapter;
import android.widget.ListView;

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
import com.TEG.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class ActivityLauncher extends ListActivity {

    private AlertDialog mErrorDialog;
    private static ArrayList<String> mActivities = new ArrayList<>();
    private static ArrayList<Integer> mActivitiesID = new ArrayList<>();

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);

        setContentView(R.layout.activities_list);
        setMuseumList();
    }

    @Override
    protected void onResume() {
        super.onResume();
        //ReCreate museum'sList
        setMuseumList();
    }

    @Override
    public void onListItemClick(ListView l, View v, int position, long id) {

        //Put Extra and direct to CloudReco
        Intent j = new Intent();
        j.putExtra("MuseumID", mActivitiesID.get(position));
        j.setClassName(getPackageName(), getPackageName() + "." + "CloudReco");
        startActivity(j);

    }

    //get String response
    public void setMuseumList() {

        // Instantiate the RequestQueue.
        RequestQueue queue = Volley.newRequestQueue(this);
        String url = "http://friendlyguider.com/museum/index.php/main/server?getMuseum&format=json";
        Log.d("ActivityLauncher", "StringRequest: " + url);
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("ActivityLauncher", "Data Response: " + response);
                        JSONArray jsonArray = null;
                        boolean isError = false;
                        try {
                            jsonArray = (new JSONObject(response)).getJSONArray("museums");
                        } catch (JSONException e) {
                            isError = true;
                            showErrorMessageJson("Dữ liệu JSON trả về lỗi", e.getMessage(), true);

                        }
                        if (!isError) {
                            addToMuseumList(jsonArray);

                            //Call function to set value to ListView
                            setAdapter();
                        }


                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

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

                showErrorMessageJson("Có lỗi trong quá trình lấy dữ liệu", message, true);
            }

        });
        //set no Cache for http request
        stringRequest.setShouldCache(false);

        //settime out for http request
        stringRequest.setRetryPolicy(new DefaultRetryPolicy(
                500,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));

        // Add the request to the RequestQueue.
        queue.add(stringRequest);
    }

    public void setAdapter() {
        ArrayAdapter<String> adapter = new ArrayAdapter<>(this,
                R.layout.activities_list_text_view, mActivities);
        setListAdapter(adapter);
    }

    public void addToMuseumList(JSONArray jsonArray) {

        mActivitiesID.clear();
        mActivities.clear();
        if (jsonArray.length() == 0) {
            showErrorMessageJson("Lấy dữ liệu bảo tàng", "Hiện tại, toàn bộ hệ thống đang được bảo trì, xin quý khác vui lòng sử dụng lại sau", true);
        }
        for (int i = 0; i < jsonArray.length(); i++) {
            try {
                int museumId = ((JSONObject) jsonArray.get(i)).getInt("museum_id");
                String museumName = ((JSONObject) jsonArray.get(i)).getString("museum_name");

                mActivitiesID.add(museumId);
                mActivities.add(museumName);

            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
    }

    public void showErrorMessageJson(final String title, final String message, final boolean finishActivityOnError) {


        runOnUiThread(new Runnable() {
            public void run() {
                if (mErrorDialog != null) {
                    mErrorDialog.dismiss();
                }

                // Create Alert Dialog to show the error message
                AlertDialog.Builder builder = new AlertDialog.Builder(
                        ActivityLauncher.this);
                builder
                        .setMessage(
                                message)
                        .setTitle(
                                title)
                        .setCancelable(false)
                        .setIcon(0)
                        .setPositiveButton(getString(R.string.button_OK),
                                new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog, int id) {
                                        if (finishActivityOnError) {
                                            finish();
                                        } else {
                                            dialog.dismiss();
                                        }
                                    }
                                });

                mErrorDialog = builder.create();
                mErrorDialog.show();
            }
        });
    }

}
