/*===============================================================================
Copyright (c) 2016 PTC Inc. All Rights Reserved.

Copyright (c) 2012-2015 Qualcomm Connected Experiences, Inc. All Rights Reserved.

Vuforia is a trademark of PTC Inc., registered in the United States and other 
countries.
===============================================================================*/


package com.vuforia.samples.VuforiaSamples.ui.ActivityList;

import android.app.ListActivity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.vuforia.samples.VuforiaSamples.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;


// This activity starts activities which demonstrate the Vuforia features
public class ActivityLauncher extends ListActivity {

//
//    private String mActivities[] = {"Bảo tàng Hồ Chí Minh", "Bảo tàng Dân tộc học Việt Nam", "Bảo tàng Mỹ thuật Việt Nam",
//            "Bảo tàng Phụ nữ Việt Nam", "Bảo tàng Lịch sử Việt Nam", "Bảo tàng Thiên nhiên Việt Nam", "Bảo tàng Hà Nội",
//            "Bảo tàng Lịch sử Quân sự Việt Nam", "Bảo tàng Cách mạng Việt Nam", "Bảo tàng Lực lượng Tăng - Thiết giáp",
//            "Bảo tàng Đường Hồ Chí Minh", "Bảo tàng Biên phòng", "Bảo tàng Phòng không-Không quân", "Bảo tàng Hậu Cần",
//            "Bảo tàng Chiến thắng B-52"};

    private ArrayList<String> mActivities = new ArrayList<String>();
    private ArrayList<Integer> mActivitiesID = new ArrayList<Integer>();

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
    public void onListItemClick(ListView l, View v, int position, long id) {

//run video
//        Intent i = new Intent();
//        i.putExtra("MuseumID", mActivitiesID.get(position));
//        i.setClassName(getPackageName(), getPackageName() + "." + "app.VideoPlayback.VideoPlayback");
//        startActivity(i);

//        //run full screen
//        Intent mPlayerHelperActivityIntent = new Intent(this,FullscreenPlayback.class);
//        mPlayerHelperActivityIntent
//                .setAction(Intent.ACTION_VIEW);
//        mPlayerHelperActivityIntent.putExtra(
//                "shouldPlayImmediately", true);
//        mPlayerHelperActivityIntent.putExtra("currentSeekPosition",
//                0);
//        mPlayerHelperActivityIntent.putExtra("requestedOrientation",
//                ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
//        this.startActivityForResult(mPlayerHelperActivityIntent, 1);

//run cloud
        Intent j = new Intent();
        j.putExtra("MuseumID", mActivitiesID.get(position));
        j.setClassName(getPackageName(), getPackageName() + "." + "app.CloudRecognition.CloudReco");
        startActivity(j);

//
//        Intent intent = new Intent(this, AboutScreen.class);
//        //intent.putExtra("ABOUT_TEXT_TITLE", mActivities[position])
//        switch (position) {
//            case 0:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.ImageTargets.ImageTargets");
//                intent.putExtra("ABOUT_TEXT", "ImageTargets/IT_about.html");
//                break;
//            case 1:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.VuMark.VuMark");
//                intent.putExtra("ABOUT_TEXT", "VuMark/VM_about.html");
//                break;
//            case 2:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.CylinderTargets.CylinderTargets");
//                intent.putExtra("ABOUT_TEXT", "CylinderTargets/CY_about.html");
//                break;
//            case 3:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.MultiTargets.MultiTargets");
//                intent.putExtra("ABOUT_TEXT", "MultiTargets/MT_about.html");
//                break;
//            case 4:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.UserDefinedTargets.UserDefinedTargets");
//                intent.putExtra("ABOUT_TEXT",
//                        "UserDefinedTargets/UD_about.html");
//                break;
//            case 5:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.ObjectRecognition.ObjectTargets");
//                intent.putExtra("ABOUT_TEXT", "ObjectRecognition/OR_about.html");
//                break;
//            case 6:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.CloudRecognition.CloudReco");
//                intent.putExtra("ABOUT_TEXT", "CloudReco/CR_about.html");
//                break;
//            case 7:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.TextRecognition.TextReco");
//                intent.putExtra("ABOUT_TEXT", "TextReco/TR_about.html");
//                break;
//            case 8:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.FrameMarkers.FrameMarkers");
//                intent.putExtra("ABOUT_TEXT", "FrameMarkers/FM_about.html");
//                break;
//            case 9:
//                intent.putExtra("ACTIVITY_TO_LAUNCH",
//                        "app.VirtualButtons.VirtualButtons");
//                intent.putExtra("ABOUT_TEXT", "VirtualButtons/VB_about.html");
//                break;
//        }
//
//        startActivity(intent);

    }

    //get String response
    public void setMuseumList() {
        // Instantiate the RequestQueue.
        RequestQueue queue = Volley.newRequestQueue(this);
        String url = "http://friendlyguider.com/museum/index.php/main/server?getMuseum&format=json";
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        JSONArray jsonArray = null;
                        try {
                            Log.d("jsonStringResponse", response);
                            jsonArray = (new JSONObject(response)).getJSONArray("museums");
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                        addToMuseumList(jsonArray);

                        //Call function to set value to ListView
                        setAdapter();

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.d("AAAA", "Lỗi getJSONObjectFromURL" + error.getMessage());
            }

        });
// Add the request to the RequestQueue.
        queue.add(stringRequest);
    }

    public void setAdapter() {
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
                R.layout.activities_list_text_view, mActivities);
        setListAdapter(adapter);
    }

    public void addToMuseumList(JSONArray jsonArray) {
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
}
