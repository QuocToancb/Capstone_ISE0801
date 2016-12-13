
package com.TEG.app;


import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.res.Configuration;
import android.graphics.Color;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.GestureDetector;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup.LayoutParams;
import android.view.animation.Animation;
import android.view.animation.LinearInterpolator;
import android.view.animation.TranslateAnimation;
import android.widget.Button;
import android.widget.RelativeLayout;

import com.vuforia.CameraDevice;
import com.vuforia.ObjectTracker;
import com.vuforia.State;
import com.vuforia.TargetFinder;
import com.vuforia.TargetSearchResult;
import com.vuforia.Trackable;
import com.vuforia.Tracker;
import com.vuforia.TrackerManager;
import com.vuforia.Vuforia;
import com.TEG.utils.ApplicationControl;
import com.TEG.utils.ApplicationException;
import com.TEG.utils.ApplicationGLView;
import com.TEG.utils.ApplicationSession;
import com.TEG.utils.LoadingDialogHandler;
import com.TEG.R;

// The main activity for the CloudReco sample.
public class CloudReco extends Activity implements ApplicationControl, MediaPlayer.OnErrorListener {
    private static final String LOGTAG = "CloudReco";

    ApplicationSession vuforiaAppSession;

    static final int HIDE_LOADING_DIALOG = 0;
    static final int SHOW_LOADING_DIALOG = 1;

    // Our OpenGL view:
    private ApplicationGLView mGlView;

    // Our renderer:
    private CloudRecoRenderer mRenderer;

    boolean mFinderStarted = false;

    // The textures we will use for rendering:

    private static final String kAccessKey = "94e96c07220b46ccee8a5d9f770ffe1aa2384bba";
    private static final String kSecretKey = "87be906007bfb56178dbcfcc52265b314d30ef2c";

    // View overlays to be displayed in the Augmented View
    private RelativeLayout mUILayout;

    // Error message handling:
    private int mlastErrorCode = 0;
    private int mInitErrorCode = 0;
    private boolean mFinishActivityOnError;

    // Alert Dialog used to display SDK errors
    private AlertDialog mErrorDialog;

    private GestureDetector mGestureDetector;

    private LoadingDialogHandler loadingDialogHandler = new LoadingDialogHandler(
            this);

    // declare scan line and its animation
    private View scanLine;
    private TranslateAnimation scanAnimation;

    private double mLastErrorTime;

    boolean mIsDroidDevice = false;

    MediaPlayer mediaPlayer;

    static Button btnAudio;
    Button btnVideo;
    int museumID;

    AudioPlayControler audioPlayControler;
    DataObject savedObject;


    // Called when the activity first starts or needs to be recreated after
    // resuming the application or a configuration change.
    @Override

    protected void onCreate(Bundle savedInstanceState) {
        Log.d(LOGTAG, "onCreate");
        super.onCreate(savedInstanceState);

        museumID = getIntent().getIntExtra("MuseumID", -1);
        vuforiaAppSession = new ApplicationSession(this);

        startLoadingAnimation();
        vuforiaAppSession
                .initAR(this, ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);

        // Creates the GestureDetector listener for processing double tap
        mGestureDetector = new GestureDetector(this, new GestureListener());
        mediaPlayer = new MediaPlayer();
        mediaPlayer.setOnErrorListener(this);
        audioPlayControler = new AudioPlayControler(mediaPlayer);

        savedObject = new DataObject();

        mIsDroidDevice = android.os.Build.MODEL.toLowerCase().startsWith(
                "droid");

    }

    // Process Single Tap event to trigger autofocus
    private class GestureListener extends
            GestureDetector.SimpleOnGestureListener {
        // Used to set autofocus one second after a manual focus is triggered
        private final Handler autofocusHandler = new Handler();


        @Override
        public boolean onDown(MotionEvent e) {
            return true;
        }


        @Override
        public boolean onSingleTapUp(MotionEvent e) {
            // Generates a Handler to trigger autofocus
            // after 1 second
            autofocusHandler.postDelayed(new Runnable() {
                public void run() {
                    boolean result = CameraDevice.getInstance().setFocusMode(
                            CameraDevice.FOCUS_MODE.FOCUS_MODE_TRIGGERAUTO);

                    if (!result)
                        Log.e("SingleTapUp", "Unable to trigger focus");
                }
            }, 1000L);

            return true;
        }
    }


    // Called when the activity will start interacting with the user.
    @Override
    protected void onResume() {
        Log.d(LOGTAG, "onResume");
        super.onResume();
        // This is needed for some Droid devices to force portrait
        if (mIsDroidDevice) {
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
        }

        try {
            vuforiaAppSession.resumeAR();
        } catch (ApplicationException e) {
            Log.e(LOGTAG, e.getString());
        }

        // Resume the GL view:
        if (mGlView != null) {
            mGlView.setVisibility(View.VISIBLE);
            mGlView.onResume();
        }

    }


    // Callback for configuration changes the activity handles itself
    @Override
    public void onConfigurationChanged(Configuration config) {
        Log.d(LOGTAG, "onConfigurationChanged");
        super.onConfigurationChanged(config);

        vuforiaAppSession.onConfigurationChanged();
    }


    // Called when the system is about to start resuming a previous activity.
    @Override
    protected void onPause() {
        Log.d(LOGTAG, "onPause");
        super.onPause();

        try {
            vuforiaAppSession.pauseAR();
        } catch (ApplicationException e) {
            Log.e(LOGTAG, e.getString());
        }

        // Pauses the OpenGLView
        if (mGlView != null) {
            mGlView.setVisibility(View.INVISIBLE);
            mGlView.onPause();
        }
        audioPlayControler.pauseIfPlaying();
        setButtonInvisible();
    }


    // The final call you receive before your activity is destroyed.
    @Override
    protected void onDestroy() {
        Log.d(LOGTAG, "onDestroy");
        super.onDestroy();

        try {
            vuforiaAppSession.stopAR();
        } catch (ApplicationException e) {
            Log.e(LOGTAG, e.getString());
        }

        audioPlayControler.releas();
        System.gc();
    }


    private void startLoadingAnimation() {
        // Inflates the Overlay Layout to be displayed above the Camera View
        LayoutInflater inflater = LayoutInflater.from(this);
        mUILayout = (RelativeLayout) inflater.inflate(R.layout.camera_overlay_with_scanline,
                null, false);

        mUILayout.setVisibility(View.VISIBLE);
        mUILayout.setBackgroundColor(Color.BLACK);

        // By default
        loadingDialogHandler.mLoadingDialogContainer = mUILayout
                .findViewById(R.id.loading_indicator);

        //QuocToan
        btnAudio = (Button) mUILayout.findViewById(R.id.btnAudio);
        btnVideo = (Button) mUILayout.findViewById(R.id.btnVideo);
        btnAudio.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (audioPlayControler.getMediaPlayer() == null) {
                    audioPlayControler.playNew(savedObject.getAudioLink());
                } else if (audioPlayControler.isPlaying()) {
                    audioPlayControler.pauseIfPlaying();
                    if (btnVideo.getVisibility() == View.INVISIBLE) {
                        btnAudio.setVisibility(View.INVISIBLE);
                    }
                } else if (audioPlayControler.isPause()) {
                    audioPlayControler.playNew(savedObject.getAudioLink());
                }
            }
        });
        btnVideo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (audioPlayControler.isPlaying()) {
                    audioPlayControler.pauseIfPlaying();
                }
                Intent mPlayerHelperActivityIntent = new Intent(getApplicationContext(), FullscreenPlayback.class);
                mPlayerHelperActivityIntent
                        .setAction(Intent.ACTION_VIEW);
                mPlayerHelperActivityIntent.putExtra(
                        "shouldPlayImmediately", true);
                mPlayerHelperActivityIntent.putExtra("currentSeekPosition",
                        0);
                mPlayerHelperActivityIntent.putExtra("videoLink", savedObject.getVideoLink());
                mPlayerHelperActivityIntent.putExtra("requestedOrientation",
                        ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
                startActivityForResult(mPlayerHelperActivityIntent, 1);
            }
        });

        loadingDialogHandler.mLoadingDialogContainer
                .setVisibility(View.VISIBLE);

        scanLine = mUILayout.findViewById(R.id.scan_line);
        scanLine.setVisibility(View.GONE);
        scanAnimation = new TranslateAnimation(
                TranslateAnimation.ABSOLUTE, 0f,
                TranslateAnimation.ABSOLUTE, 0f,
                TranslateAnimation.RELATIVE_TO_PARENT, 0f,
                TranslateAnimation.RELATIVE_TO_PARENT, 1.0f);
        scanAnimation.setDuration(4000);
        scanAnimation.setRepeatCount(-1);
        scanAnimation.setRepeatMode(Animation.REVERSE);
        scanAnimation.setInterpolator(new LinearInterpolator());

        addContentView(mUILayout, new LayoutParams(LayoutParams.MATCH_PARENT,
                LayoutParams.MATCH_PARENT));

    }


    // Initializes AR application components.
    private void initApplicationAR() {
        // Create OpenGL ES view:
        int depthSize = 16;
        int stencilSize = 0;
        boolean translucent = Vuforia.requiresAlpha();

        // Initialize the GLView with proper flags
        mGlView = new ApplicationGLView(this);
        mGlView.init(translucent, depthSize, stencilSize);

        // Setups the Renderer of the GLView
        mRenderer = new CloudRecoRenderer(vuforiaAppSession, this);
        mGlView.setRenderer(mRenderer);

    }


    // Returns the error message for each error code
    private String getStatusDescString(int code) {
        if (code == TargetFinder.UPDATE_ERROR_AUTHORIZATION_FAILED)
            return getString(R.string.UPDATE_ERROR_AUTHORIZATION_FAILED_DESC);
        if (code == TargetFinder.UPDATE_ERROR_PROJECT_SUSPENDED)
            return getString(R.string.UPDATE_ERROR_PROJECT_SUSPENDED_DESC);
        if (code == TargetFinder.UPDATE_ERROR_NO_NETWORK_CONNECTION)
            return getString(R.string.UPDATE_ERROR_NO_NETWORK_CONNECTION_DESC);
        if (code == TargetFinder.UPDATE_ERROR_SERVICE_NOT_AVAILABLE)
            return getString(R.string.UPDATE_ERROR_SERVICE_NOT_AVAILABLE_DESC);
        if (code == TargetFinder.UPDATE_ERROR_UPDATE_SDK)
            return getString(R.string.UPDATE_ERROR_UPDATE_SDK_DESC);
        if (code == TargetFinder.UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE)
            return getString(R.string.UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE_DESC);
        if (code == TargetFinder.UPDATE_ERROR_REQUEST_TIMEOUT)
            return getString(R.string.UPDATE_ERROR_REQUEST_TIMEOUT_DESC);
        if (code == TargetFinder.UPDATE_ERROR_BAD_FRAME_QUALITY)
            return getString(R.string.UPDATE_ERROR_BAD_FRAME_QUALITY_DESC);
        else {
            return getString(R.string.UPDATE_ERROR_UNKNOWN_DESC);
        }
    }


    // Returns the error message for each error code
    private String getStatusTitleString(int code) {
        if (code == TargetFinder.UPDATE_ERROR_AUTHORIZATION_FAILED)
            return getString(R.string.UPDATE_ERROR_AUTHORIZATION_FAILED_TITLE);
        if (code == TargetFinder.UPDATE_ERROR_PROJECT_SUSPENDED)
            return getString(R.string.UPDATE_ERROR_PROJECT_SUSPENDED_TITLE);
        if (code == TargetFinder.UPDATE_ERROR_NO_NETWORK_CONNECTION)
            return getString(R.string.UPDATE_ERROR_NO_NETWORK_CONNECTION_TITLE);
        if (code == TargetFinder.UPDATE_ERROR_SERVICE_NOT_AVAILABLE)
            return getString(R.string.UPDATE_ERROR_SERVICE_NOT_AVAILABLE_TITLE);
        if (code == TargetFinder.UPDATE_ERROR_UPDATE_SDK)
            return getString(R.string.UPDATE_ERROR_UPDATE_SDK_TITLE);
        if (code == TargetFinder.UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE)
            return getString(R.string.UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE_TITLE);
        if (code == TargetFinder.UPDATE_ERROR_REQUEST_TIMEOUT)
            return getString(R.string.UPDATE_ERROR_REQUEST_TIMEOUT_TITLE);
        if (code == TargetFinder.UPDATE_ERROR_BAD_FRAME_QUALITY)
            return getString(R.string.UPDATE_ERROR_BAD_FRAME_QUALITY_TITLE);
        else {
            return getString(R.string.UPDATE_ERROR_UNKNOWN_TITLE);
        }
    }


    // Shows error messages as System dialogs
    public void showErrorMessage(int errorCode, double errorTime, boolean finishActivityOnError) {
        if (errorTime < (mLastErrorTime + 5.0) || errorCode == mlastErrorCode)
            return;

        mlastErrorCode = errorCode;
        mFinishActivityOnError = finishActivityOnError;

        runOnUiThread(new Runnable() {
            public void run() {
                if (mErrorDialog != null) {
                    mErrorDialog.dismiss();
                }

                // Generates an Alert Dialog to show the error message
                AlertDialog.Builder builder = new AlertDialog.Builder(
                        CloudReco.this);
                builder
                        .setMessage(
                                getStatusDescString(CloudReco.this.mlastErrorCode))
                        .setTitle(
                                getStatusTitleString(CloudReco.this.mlastErrorCode))
                        .setCancelable(false)
                        .setIcon(0)
                        .setPositiveButton(getString(R.string.button_OK),
                                new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog, int id) {
                                        if (mFinishActivityOnError) {
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

    public void showErrorMessageJson(final String title, final String message, final boolean finishActivityOnError) {


        runOnUiThread(new Runnable() {
            public void run() {
                if (mErrorDialog != null) {
                    mErrorDialog.dismiss();
                }

                // Generates an Alert Dialog to show the error message
                AlertDialog.Builder builder = new AlertDialog.Builder(
                        CloudReco.this);
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


    // Shows initialization error messages as System dialogs
    public void showInitializationErrorMessage(String message) {
        final String errorMessage = message;
        runOnUiThread(new Runnable() {
            public void run() {
                if (mErrorDialog != null) {
                    mErrorDialog.dismiss();
                }

                // Generates an Alert Dialog to show the error message
                AlertDialog.Builder builder = new AlertDialog.Builder(
                        CloudReco.this);
                builder
                        .setMessage(errorMessage)
                        .setTitle(getString(R.string.INIT_ERROR))
                        .setCancelable(false)
                        .setIcon(0)
                        .setPositiveButton(getString(R.string.button_OK),
                                new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog, int id) {
                                        finish();
                                    }
                                });

                mErrorDialog = builder.create();
                mErrorDialog.show();
            }
        });
    }


    public void startFinderIfStopped() {
        if (!mFinderStarted) {
            mFinderStarted = true;

            // Get the object tracker:
            TrackerManager trackerManager = TrackerManager.getInstance();
            ObjectTracker objectTracker = (ObjectTracker) trackerManager
                    .getTracker(ObjectTracker.getClassType());

            // Initialize target finder:
            TargetFinder targetFinder = objectTracker.getTargetFinder();

            targetFinder.clearTrackables();
            targetFinder.startRecognition();
            scanlineStart();

            //Manager Button visible
            targetLost();

        }
    }


    public void stopFinderIfStarted() {
        if (mFinderStarted) {
            mFinderStarted = false;

            // Get the object tracker:
            TrackerManager trackerManager = TrackerManager.getInstance();
            ObjectTracker objectTracker = (ObjectTracker) trackerManager
                    .getTracker(ObjectTracker.getClassType());

            // Initialize target finder:
            TargetFinder targetFinder = objectTracker.getTargetFinder();

            targetFinder.stop();
            scanlineStop();

            //Display button when targetFound
            targetFound();
        }
    }


    @Override
    public boolean onTouchEvent(MotionEvent event) {
        // Process the Gestures

        return mGestureDetector.onTouchEvent(event);
    }


    @Override
    public boolean doLoadTrackersData() {
        Log.d(LOGTAG, "initCloudReco");

        // Get the object tracker:
        TrackerManager trackerManager = TrackerManager.getInstance();
        ObjectTracker objectTracker = (ObjectTracker) trackerManager
                .getTracker(ObjectTracker.getClassType());

        // Initialize target finder:
        TargetFinder targetFinder = objectTracker.getTargetFinder();

        // Start initialization:
        if (targetFinder.startInit(kAccessKey, kSecretKey)) {
            targetFinder.waitUntilInitFinished();
        }

        int resultCode = targetFinder.getInitState();
        if (resultCode != TargetFinder.INIT_SUCCESS) {
            if (resultCode == TargetFinder.INIT_ERROR_NO_NETWORK_CONNECTION) {
                mInitErrorCode = TargetFinder.UPDATE_ERROR_NO_NETWORK_CONNECTION;
            } else {
                mInitErrorCode = TargetFinder.UPDATE_ERROR_SERVICE_NOT_AVAILABLE;
            }

            Log.e(LOGTAG, "Failed to initialize target finder.");
            return false;
        }

        return true;
    }


    @Override
    public boolean doUnloadTrackersData() {
        return true;
    }


    @Override
    public void onInitARDone(ApplicationException exception) {

        if (exception == null) {
            initApplicationAR();

            // Now add the GL surface view. It is important
            // that the OpenGL ES surface view gets added
            // BEFORE the camera is started and video
            // background is configured.
            addContentView(mGlView, new LayoutParams(LayoutParams.MATCH_PARENT,
                    LayoutParams.MATCH_PARENT));

            // Start the camera:
            try {
                vuforiaAppSession.startAR(CameraDevice.CAMERA_DIRECTION.CAMERA_DIRECTION_DEFAULT);
            } catch (ApplicationException e) {
                Log.e(LOGTAG, e.getString());
            }

            boolean result = CameraDevice.getInstance().setFocusMode(
                    CameraDevice.FOCUS_MODE.FOCUS_MODE_CONTINUOUSAUTO);

            if (!result)
                Log.e(LOGTAG, "Unable to enable continuous autofocus");

            mUILayout.bringToFront();

            // Hides the Loading Dialog
            loadingDialogHandler.sendEmptyMessage(HIDE_LOADING_DIALOG);

            mUILayout.setBackgroundColor(Color.TRANSPARENT);


        } else {
            Log.e(LOGTAG, exception.getString());
            if (mInitErrorCode != 0) {
                showErrorMessage(mInitErrorCode, 10, true);
            } else {
                showInitializationErrorMessage(exception.getString());
            }
        }
    }


    @Override
    public void onVuforiaUpdate(State state) {
        // Get the tracker manager:
        TrackerManager trackerManager = TrackerManager.getInstance();

        // Get the object tracker:
        ObjectTracker objectTracker = (ObjectTracker) trackerManager
                .getTracker(ObjectTracker.getClassType());

        // Get the target finder:
        TargetFinder finder = objectTracker.getTargetFinder();

        // Check if there are new results available:
        final int statusCode = finder.updateSearchResults();

        // Show a message if we encountered an error:
        if (statusCode < 0) {

            boolean closeAppAfterError = (
                    statusCode == TargetFinder.UPDATE_ERROR_NO_NETWORK_CONNECTION ||
                            statusCode == TargetFinder.UPDATE_ERROR_SERVICE_NOT_AVAILABLE);

            showErrorMessage(statusCode, state.getFrame().getTimeStamp(), closeAppAfterError);

        } else if (statusCode == TargetFinder.UPDATE_RESULTS_AVAILABLE) {
            // Process new search results
            if (finder.getResultCount() > 0) {
                TargetSearchResult result = finder.getResult(0);

                // Check if this target is suitable for tracking:
                if (result.getTrackingRating() > 0) {
                    Trackable trackable = finder.enableTracking(result);
                }
            }
        }
    }


    @Override
    public boolean doInitTrackers() {
        TrackerManager tManager = TrackerManager.getInstance();
        Tracker tracker;

        // Indicate if the trackers were initialized correctly
        boolean result = true;

        tracker = tManager.initTracker(ObjectTracker.getClassType());
        if (tracker == null) {
            Log.e(
                    LOGTAG,
                    "Tracker not initialized. Tracker already initialized or the camera is already started");
            result = false;
        } else {
            Log.i(LOGTAG, "Tracker successfully initialized");
        }

        return result;
    }


    @Override
    public boolean doStartTrackers() {
        // Indicate if the trackers were started correctly

        // Start the tracker:
        TrackerManager trackerManager = TrackerManager.getInstance();
        ObjectTracker objectTracker = (ObjectTracker) trackerManager
                .getTracker(ObjectTracker.getClassType());
        objectTracker.start();

        // Start cloud based recognition if we are in scanning mode:
        TargetFinder targetFinder = objectTracker.getTargetFinder();
        targetFinder.startRecognition();
        scanlineStart();
        mFinderStarted = true;

        return true;
    }


    @Override
    public boolean doStopTrackers() {
        // Indicate if the trackers were stopped correctly
        boolean result = true;

        TrackerManager trackerManager = TrackerManager.getInstance();
        ObjectTracker objectTracker = (ObjectTracker) trackerManager
                .getTracker(ObjectTracker.getClassType());

        if (objectTracker != null) {
            objectTracker.stop();

            // Stop cloud based recognition:
            TargetFinder targetFinder = objectTracker.getTargetFinder();
            targetFinder.stop();
            scanlineStop();
            mFinderStarted = false;

            // Clears the trackables
            targetFinder.clearTrackables();
        } else {
            result = false;
        }

        return result;
    }


    @Override
    public boolean doDeinitTrackers() {
        // Indicate if the trackers were deinitialized correctly

        TrackerManager tManager = TrackerManager.getInstance();
        tManager.deinitTracker(ObjectTracker.getClassType());

        return true;
    }


    private void scanlineStart() {
        this.runOnUiThread(new Runnable() {
            @Override
            public void run() {
                scanLine.setVisibility(View.VISIBLE);
                scanLine.setAnimation(scanAnimation);
            }
        });
    }

    private void scanlineStop() {
        this.runOnUiThread(new Runnable() {
            @Override
            public void run() {
                scanLine.setVisibility(View.GONE);
                scanLine.clearAnimation();
            }
        });
    }

    public void targetLost() {
        Message msg1 = handlerButtonDisplayer.obtainMessage();
        msg1.arg1 = 0;
        handlerButtonDisplayer.sendMessage(msg1);

    }

    public void targetFound() {
        Message msg1 = handlerButtonDisplayer.obtainMessage();
        msg1.arg1 = 1;
        handlerButtonDisplayer.sendMessage(msg1);
    }

    public void setButtonVisible() {
        if (savedObject.getAudioLink().compareTo("") != 0) {
            btnAudio.setVisibility(View.VISIBLE);
        } else {
            btnAudio.setVisibility(View.INVISIBLE);
        }

        if (savedObject.getVideoLink().compareTo("") != 0) {
            btnVideo.setVisibility(View.VISIBLE);
        } else {
            btnVideo.setVisibility(View.INVISIBLE);
        }

    }

    public void setButtonInvisible() {
        try {
            if (audioPlayControler.isPlaying()) {
                btnAudio.setVisibility(View.VISIBLE);
            } else {
                btnAudio.setVisibility(View.INVISIBLE);
            }
        } catch (IllegalStateException ex) {
            btnAudio.setVisibility(View.INVISIBLE);
        }

        btnVideo.setVisibility(View.INVISIBLE);
    }


    private final Handler handlerButtonDisplayer = new Handler() {
        public void handleMessage(Message msg) {
            //targetFound
            if (msg.arg1 == 0) {
                setButtonInvisible();
            } else if (msg.arg1 == 1)
            //targetLost
            {
                setButtonVisible();
            }

        }
    };

    public boolean onError(MediaPlayer mp, int what, int extra) {
        if (mp == mediaPlayer) {
            String errorDescription;

            switch (what) {
                case MediaPlayer.MEDIA_ERROR_NOT_VALID_FOR_PROGRESSIVE_PLAYBACK:
                    errorDescription = "Audio có chứa dữ liệu lỗi trong quá trình phát";
                    break;

                case MediaPlayer.MEDIA_ERROR_SERVER_DIED:
                    errorDescription = "Mất kết nối với máy chủ";
                    break;

                case MediaPlayer.MEDIA_ERROR_UNKNOWN:
                    errorDescription = "Kết nối đến máy chủ không ổn định";
                    break;

                default:
                    errorDescription = "Lỗi không xác định " + what;
                    break;
            }

            showErrorMessageJson("Lỗi phát âm thanh", errorDescription + "/nVui lòng thử lại sau", true);

            Log.e(LOGTAG, "Lỗi phát âm thanh. "
                    + "Không thể chuẩn bị được dữ liệu (" + errorDescription + ", "
                    + extra + ")");

            return true;
        }

        return false;
    }

}
