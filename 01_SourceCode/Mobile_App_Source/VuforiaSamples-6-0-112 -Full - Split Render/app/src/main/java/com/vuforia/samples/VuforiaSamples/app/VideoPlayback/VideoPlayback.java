/*===============================================================================
Copyright (c) 2016 PTC Inc. All Rights Reserved.


Copyright (c) 2012-2014 Qualcomm Connected Experiences, Inc. All Rights Reserved.

Vuforia is a trademark of PTC Inc., registered in the United States and other 
countries.
===============================================================================*/

package com.vuforia.samples.VuforiaSamples.app.VideoPlayback;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.res.Configuration;
import android.graphics.Color;
import android.media.AudioManager;
import android.media.MediaPlayer;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.GestureDetector;
import android.view.GestureDetector.OnDoubleTapListener;
import android.view.GestureDetector.SimpleOnGestureListener;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup.LayoutParams;
import android.view.animation.Animation;
import android.view.animation.LinearInterpolator;
import android.view.animation.TranslateAnimation;
import android.widget.Button;
import android.widget.RelativeLayout;
import android.widget.Toast;

import com.vuforia.CameraDevice;
import com.vuforia.DataSet;
import com.vuforia.HINT;
import com.vuforia.ObjectTracker;
import com.vuforia.State;
import com.vuforia.TargetFinder;
import com.vuforia.Tracker;
import com.vuforia.TrackerManager;
import com.vuforia.Vuforia;
import com.vuforia.samples.SampleApplication.SampleApplicationControl;
import com.vuforia.samples.SampleApplication.SampleApplicationException;
import com.vuforia.samples.SampleApplication.SampleApplicationSession;
import com.vuforia.samples.SampleApplication.utils.LoadingDialogHandler;
import com.vuforia.samples.SampleApplication.utils.SampleApplicationGLView;
import com.vuforia.samples.SampleApplication.utils.Texture;
import com.vuforia.samples.VuforiaSamples.R;
import com.vuforia.samples.VuforiaSamples.app.VideoPlayback.VideoPlayerHelper.MEDIA_STATE;
import com.vuforia.samples.VuforiaSamples.ui.SampleAppMenu.SampleAppMenu;
import com.vuforia.samples.VuforiaSamples.ui.SampleAppMenu.SampleAppMenuGroup;
import com.vuforia.samples.VuforiaSamples.ui.SampleAppMenu.SampleAppMenuInterface;

import java.util.Vector;


// The AR activity for the VideoPlayback sample.
public class VideoPlayback extends Activity implements
        SampleApplicationControl, SampleAppMenuInterface {
    MediaPlayer mediaPlayer;
    private static final String LOGTAG = "VideoPlayback";

    SampleApplicationSession vuforiaAppSession;

    Activity mActivity;

    // These codes match the ones defined in TargetFinder in Vuforia.jar
    static final int INIT_SUCCESS = 2;
    static final int INIT_ERROR_NO_NETWORK_CONNECTION = -1;
    static final int INIT_ERROR_SERVICE_NOT_AVAILABLE = -2;
    static final int UPDATE_ERROR_AUTHORIZATION_FAILED = -1;
    static final int UPDATE_ERROR_PROJECT_SUSPENDED = -2;
    static final int UPDATE_ERROR_NO_NETWORK_CONNECTION = -3;
    static final int UPDATE_ERROR_SERVICE_NOT_AVAILABLE = -4;
    static final int UPDATE_ERROR_BAD_FRAME_QUALITY = -5;
    static final int UPDATE_ERROR_UPDATE_SDK = -6;
    static final int UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE = -7;
    static final int UPDATE_ERROR_REQUEST_TIMEOUT = -8;

    static final int HIDE_LOADING_DIALOG = 0;
    static final int SHOW_LOADING_DIALOG = 1;

    // Helpers to detect events such as double tapping:
    private GestureDetector mGestureDetector = null;
    private SimpleOnGestureListener mSimpleListener = null;


    //QuocTOan
    public static int check = -1;
    // Movie for the Targets:
    public static final int NUM_TARGETS = 1;
    public static final int STONES = 0;
    public static final int CHIPS = 1;
    private VideoPlayerHelper mVideoPlayerHelper[] = null;
    private int mSeekPosition[] = null;
    private boolean mWasPlaying[] = null;
    private String mMovieName[] = null;

    // A boolean to indicate whether we come from full screen:
    private boolean mReturningFromFullScreen = false;

    // Our OpenGL view:
    private SampleApplicationGLView mGlView;

    // Our renderer:
    private VideoPlaybackRenderer mRenderer;

    // The textures we will use for rendering:
    private Vector<Texture> mTextures;

    DataSet dataSetStonesAndChips = null;

    private RelativeLayout mUILayout;

    private boolean mPlayFullscreenVideo = false;

    private SampleAppMenu mSampleAppMenu;

    private LoadingDialogHandler loadingDialogHandler = new LoadingDialogHandler(
            this);

    // Alert Dialog used to display SDK errors
    private AlertDialog mErrorDialog;

    boolean mIsDroidDevice = false;
    boolean mIsInitialized = false;


    //QuocToan
    //Mykey
//    private static final String kAccessKey = "c33bfc548a0f6d082e56bba1e69f5cde4d82b1c4";
//    private static final String kSecretKey = "5b480bd1b978d4b0d24a0a55e0d86e8e3c899575";

    boolean mFinderStarted = false;

    private double mLastErrorTime;
    Button btnAudio;
    Button btnVideo;
    boolean isplaying = false;

    // Error message handling:
    private int mlastErrorCode = 0;
    private int mInitErrorCode = 0;
    private boolean mFinishActivityOnError;

    // Called when the activity first starts or the user navigates back
    // to an activity.

    // declare scan line and its animation
    private View scanLine;
    private TranslateAnimation scanAnimation;

    protected void onCreate(Bundle savedInstanceState) {

        Log.d(LOGTAG, "onCreate");
        super.onCreate(savedInstanceState);

        vuforiaAppSession = new SampleApplicationSession(this);

        mActivity = this;

        startLoadingAnimation();

        vuforiaAppSession
                .initAR(this, ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);

        // Load any sample specific textures:
        mTextures = new Vector<Texture>();
        loadTextures();

        // Create the gesture detector that will handle the single and
        // double taps:
        mSimpleListener = new SimpleOnGestureListener();
        mGestureDetector = new GestureDetector(getApplicationContext(),
                mSimpleListener);

        mVideoPlayerHelper = new VideoPlayerHelper[NUM_TARGETS];
        mSeekPosition = new int[NUM_TARGETS];
        mWasPlaying = new boolean[NUM_TARGETS];
        mMovieName = new String[NUM_TARGETS];

        // Create the video player helper that handles the playback of the movie
        // for the targets:
        for (int i = 0; i < NUM_TARGETS; i++) {
            mVideoPlayerHelper[i] = new VideoPlayerHelper();
            mVideoPlayerHelper[i].init();
            mVideoPlayerHelper[i].setActivity(this);
        }

        //mMovieName[STONES] = "VideoPlayback/VuforiaSizzleReel_1.mp4";
        //mMovieName[CHIPS] = "VideoPlayback/VuforiaSizzleReel_2.mp4";

        // Set the double tap listener:
        mGestureDetector.setOnDoubleTapListener(new OnDoubleTapListener() {
            public boolean onDoubleTap(MotionEvent e) {
                // We do not react to this event
                return false;
            }


            public boolean onDoubleTapEvent(MotionEvent e) {
                // We do not react to this event
                toastMe("this is doublt tab");
                return false;
            }


            // Handle the single tap
            public boolean onSingleTapConfirmed(MotionEvent e) {
                boolean isSingleTapHandled = false;
                // Do not react if the StartupScreen is being displayed
                for (int i = 0; i < NUM_TARGETS; i++) {
                    // Verify that the tap happened inside the target
                    if (mRenderer != null && mRenderer.isTapOnScreenInsideTarget(i, e.getX(),
                            e.getY())) {
                        // Check if it is playable on texture
                        if (mVideoPlayerHelper[i].isPlayableOnTexture()) {
                            // We can play only if the movie was paused, ready
                            // or stopped
                            if ((mVideoPlayerHelper[i].getStatus() == MEDIA_STATE.PAUSED)
                                    || (mVideoPlayerHelper[i].getStatus() == MEDIA_STATE.READY)
                                    || (mVideoPlayerHelper[i].getStatus() == MEDIA_STATE.STOPPED)
                                    || (mVideoPlayerHelper[i].getStatus() == MEDIA_STATE.REACHED_END)) {
                                // Pause all other media
                                pauseAll(i);

                                // If it has reached the end then rewind
                                if ((mVideoPlayerHelper[i].getStatus() == MEDIA_STATE.REACHED_END))
                                    mSeekPosition[i] = 0;

                                mVideoPlayerHelper[i].play(mPlayFullscreenVideo,
                                        mSeekPosition[i]);
                                mSeekPosition[i] = VideoPlayerHelper.CURRENT_POSITION;
                            } else if (mVideoPlayerHelper[i].getStatus() == MEDIA_STATE.PLAYING) {
                                // If it is playing then we pause it
                                mVideoPlayerHelper[i].pause();
                            }
                        } else if (mVideoPlayerHelper[i].isPlayableFullscreen()) {
                            // If it isn't playable on texture
                            // Either because it wasn't requested or because it
                            // isn't supported then request playback fullscreen.
                            mVideoPlayerHelper[i].play(true,
                                    VideoPlayerHelper.CURRENT_POSITION);
                        }

                        isSingleTapHandled = true;

                        // Even though multiple videos can be loaded only one
                        // can be playing at any point in time. This break
                        // prevents that, say, overlapping videos trigger
                        // simultaneously playback.
                        break;
                    }
                }

                return isSingleTapHandled;
            }
        });
        Log.d("AAAA", "Ket thuc oncreate");
    }


    // We want to load specific textures from the APK, which we will later
    // use for rendering.
    private void loadTextures() {
        mTextures.add(Texture.loadTextureFromApk(
                "VideoPlayback/VuforiaSizzleReel_1.png", getAssets()));
        mTextures.add(Texture.loadTextureFromApk(
                "VideoPlayback/VuforiaSizzleReel_2.png", getAssets()));
        mTextures.add(Texture.loadTextureFromApk("VideoPlayback/play.png",
                getAssets()));
        mTextures.add(Texture.loadTextureFromApk("VideoPlayback/busy.png",
                getAssets()));
        mTextures.add(Texture.loadTextureFromApk("VideoPlayback/error.png",
                getAssets()));
    }


    // Called when the activity will start interacting with the user.
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
        } catch (SampleApplicationException e) {
            Log.e(LOGTAG, e.getString());
        }

        // Resume the GL view:
        if (mGlView != null) {
            mGlView.setVisibility(View.VISIBLE);
            mGlView.onResume();
        }

        // Reload all the movies
        if (mRenderer != null) {
            for (int i = 0; i < NUM_TARGETS; i++) {
                if (!mReturningFromFullScreen) {
                    mRenderer.requestLoad(i, mMovieName[i], mSeekPosition[i],
                            false);
                } else {
                    mRenderer.requestLoad(i, mMovieName[i], mSeekPosition[i],
                            mWasPlaying[i]);
                }
            }
        }

        mReturningFromFullScreen = false;
    }


    // Called when returning from the full screen player
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == 1) {

            mActivity.setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);

            if (resultCode == RESULT_OK) {
                // The following values are used to indicate the position in
                // which the video was being played and whether it was being
                // played or not:
                String movieBeingPlayed = data.getStringExtra("movieName");
                mReturningFromFullScreen = true;

                // Find the movie that was being played full screen
                for (int i = 0; i < NUM_TARGETS; i++) {
                    if (movieBeingPlayed.compareTo(mMovieName[i]) == 0) {
                        mSeekPosition[i] = data.getIntExtra(
                                "currentSeekPosition", 0);
                        mWasPlaying[i] = false;
                    }
                }
            }
        }
    }


    public void onConfigurationChanged(Configuration config) {
        Log.d(LOGTAG, "onConfigurationChanged");
        super.onConfigurationChanged(config);

        vuforiaAppSession.onConfigurationChanged();
    }


    // Called when the system is about to start resuming a previous activity.
    protected void onPause() {
        Log.d(LOGTAG, "onPause");
        super.onPause();

        if (mGlView != null) {
            mGlView.setVisibility(View.INVISIBLE);
            mGlView.onPause();
        }

        // Store the playback state of the movies and unload them:
        for (int i = 0; i < NUM_TARGETS; i++) {
            // If the activity is paused we need to store the position in which
            // this was currently playing:
            if (mVideoPlayerHelper[i].isPlayableOnTexture()) {
                mSeekPosition[i] = mVideoPlayerHelper[i].getCurrentPosition();
                mWasPlaying[i] = mVideoPlayerHelper[i].getStatus() == MEDIA_STATE.PLAYING ? true
                        : false;
            }

            // We also need to release the resources used by the helper, though
            // we don't need to destroy it:
            if (mVideoPlayerHelper[i] != null)
                mVideoPlayerHelper[i].unload();
        }

        mReturningFromFullScreen = false;

        try {
            vuforiaAppSession.pauseAR();
        } catch (SampleApplicationException e) {
            Log.e(LOGTAG, e.getString());
        }
        if (mediaPlayer != null) {
            stop();
        }
    }


    // The final call you receive before your activity is destroyed.
    protected void onDestroy() {
        Log.d(LOGTAG, "onDestroy");
        super.onDestroy();

        for (int i = 0; i < NUM_TARGETS; i++) {
            // If the activity is destroyed we need to release all resources:
            if (mVideoPlayerHelper[i] != null)
                mVideoPlayerHelper[i].deinit();
            mVideoPlayerHelper[i] = null;
        }

        try {
            vuforiaAppSession.stopAR();
        } catch (SampleApplicationException e) {
            Log.e(LOGTAG, e.getString());
        }

        // Unload texture:
        mTextures.clear();
        mTextures = null;

        System.gc();
    }


    // Pause all movies except one
    // if the value of 'except' is -1 then
    // do a blanket pause
    private void pauseAll(int except) {
        // And pause all the playing videos:
        for (int i = 0; i < NUM_TARGETS; i++) {
            // We can make one exception to the pause all calls:
            if (i != except) {
                // Check if the video is playable on texture
                if (mVideoPlayerHelper[i].isPlayableOnTexture()) {
                    // If it is playing then we pause it
                    mVideoPlayerHelper[i].pause();
                }
            }
        }
    }


    // Do not exit immediately and instead show the startup screen
    public void onBackPressed() {
        pauseAll(-1);
        super.onBackPressed();
    }


    private void startLoadingAnimation() {
        mUILayout = (RelativeLayout) View.inflate(this, R.layout.camera_overlay_with_scanline,
                null);

        mUILayout.setVisibility(View.VISIBLE);
        mUILayout.setBackgroundColor(Color.BLACK);

        // Gets a reference to the loading dialog
        loadingDialogHandler.mLoadingDialogContainer = mUILayout
                .findViewById(R.id.loading_indicator);

        //QuocToan
        btnAudio = (Button) mUILayout.findViewById(R.id.btnAudio);
        btnVideo = (Button) mUILayout.findViewById(R.id.btnVideo);
        btnAudio.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (check != 0) {
                    check = 0;
                } else {
                    pause();
                }
            }
        });
        btnVideo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                check = 1;
                stop();
            }
        });
        // Shows the loading indicator at start
        loadingDialogHandler
                .sendEmptyMessage(LoadingDialogHandler.SHOW_LOADING_DIALOG);

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

        // Adds the inflated layout to the view
        addContentView(mUILayout, new LayoutParams(LayoutParams.MATCH_PARENT,
                LayoutParams.MATCH_PARENT));
    }


    // Initializes AR application components.
    private void initApplicationAR() {
        // Create OpenGL ES view:
        int depthSize = 16;
        int stencilSize = 0;
        boolean translucent = Vuforia.requiresAlpha();

        mGlView = new SampleApplicationGLView(this);
        mGlView.init(translucent, depthSize, stencilSize);

        mRenderer = new VideoPlaybackRenderer(this, vuforiaAppSession);
        mRenderer.setTextures(mTextures);

        // The renderer comes has the OpenGL context, thus, loading to texture
        // must happen when the surface has been created. This means that we
        // can't load the movie from this thread (GUI) but instead we must
        // tell the GL thread to load it once the surface has been created.
        for (int i = 0; i < NUM_TARGETS; i++) {
            mRenderer.setVideoPlayerHelper(i, mVideoPlayerHelper[i]);
            mRenderer.requestLoad(i, mMovieName[i], 0, false);
        }

        mGlView.setRenderer(mRenderer);

        for (int i = 0; i < NUM_TARGETS; i++) {
            float[] temp = {0f, 0f, 0f};
            mRenderer.targetPositiveDimensions[i].setData(temp);
            mRenderer.videoPlaybackTextureID[i] = -1;
        }

    }

    // Returns the error message for each error code
    private String getStatusDescString(int code) {
        if (code == UPDATE_ERROR_AUTHORIZATION_FAILED)
            return getString(R.string.UPDATE_ERROR_AUTHORIZATION_FAILED_DESC);
        if (code == UPDATE_ERROR_PROJECT_SUSPENDED)
            return getString(R.string.UPDATE_ERROR_PROJECT_SUSPENDED_DESC);
        if (code == UPDATE_ERROR_NO_NETWORK_CONNECTION)
            return getString(R.string.UPDATE_ERROR_NO_NETWORK_CONNECTION_DESC);
        if (code == UPDATE_ERROR_SERVICE_NOT_AVAILABLE)
            return getString(R.string.UPDATE_ERROR_SERVICE_NOT_AVAILABLE_DESC);
        if (code == UPDATE_ERROR_UPDATE_SDK)
            return getString(R.string.UPDATE_ERROR_UPDATE_SDK_DESC);
        if (code == UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE)
            return getString(R.string.UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE_DESC);
        if (code == UPDATE_ERROR_REQUEST_TIMEOUT)
            return getString(R.string.UPDATE_ERROR_REQUEST_TIMEOUT_DESC);
        if (code == UPDATE_ERROR_BAD_FRAME_QUALITY)
            return getString(R.string.UPDATE_ERROR_BAD_FRAME_QUALITY_DESC);
        else {
            return getString(R.string.UPDATE_ERROR_UNKNOWN_DESC);
        }
    }

    // Returns the error message for each error code
    private String getStatusTitleString(int code) {
        if (code == UPDATE_ERROR_AUTHORIZATION_FAILED)
            return getString(R.string.UPDATE_ERROR_AUTHORIZATION_FAILED_TITLE);
        if (code == UPDATE_ERROR_PROJECT_SUSPENDED)
            return getString(R.string.UPDATE_ERROR_PROJECT_SUSPENDED_TITLE);
        if (code == UPDATE_ERROR_NO_NETWORK_CONNECTION)
            return getString(R.string.UPDATE_ERROR_NO_NETWORK_CONNECTION_TITLE);
        if (code == UPDATE_ERROR_SERVICE_NOT_AVAILABLE)
            return getString(R.string.UPDATE_ERROR_SERVICE_NOT_AVAILABLE_TITLE);
        if (code == UPDATE_ERROR_UPDATE_SDK)
            return getString(R.string.UPDATE_ERROR_UPDATE_SDK_TITLE);
        if (code == UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE)
            return getString(R.string.UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE_TITLE);
        if (code == UPDATE_ERROR_REQUEST_TIMEOUT)
            return getString(R.string.UPDATE_ERROR_REQUEST_TIMEOUT_TITLE);
        if (code == UPDATE_ERROR_BAD_FRAME_QUALITY)
            return getString(R.string.UPDATE_ERROR_BAD_FRAME_QUALITY_TITLE);
        else {
            return getString(R.string.UPDATE_ERROR_UNKNOWN_TITLE);
        }
    }

    // We do not handle the touch event here, we just forward it to the
    // gesture detector
    public boolean onTouchEvent(MotionEvent event) {
        boolean result = false;
        if (mSampleAppMenu != null)
            result = mSampleAppMenu.processEvent(event);

        // Process the Gestures
        if (!result)
            mGestureDetector.onTouchEvent(event);

        return result;
    }


    @Override
    public boolean doInitTrackers() {
        // Indicate if the trackers were initialized correctly
        boolean result = true;

        // Initialize the image tracker:
        TrackerManager trackerManager = TrackerManager.getInstance();
        Tracker tracker = trackerManager.initTracker(ObjectTracker.getClassType());
        if (tracker == null) {
            Log.d(LOGTAG, "Failed to initialize ObjectTracker.");
            result = false;
        }

        return result;
    }


    @Override
    public boolean doLoadTrackersData() {
        // Get the object tracker:
        TrackerManager trackerManager = TrackerManager.getInstance();
        ObjectTracker objectTracker = (ObjectTracker) trackerManager
                .getTracker(ObjectTracker.getClassType());
        if (objectTracker == null) {
            Log.d(
                    LOGTAG,
                    "Failed to load tracking data set because the ObjectTracker has not been initialized.");
            return false;
        }


        // Initialize target finder:
        TargetFinder targetFinder = objectTracker.getTargetFinder();

        // Start initialization:
        String kAccessKey = "c33bfc548a0f6d082e56bba1e69f5cde4d82b1c4";
        String kSecretKey = "5b480bd1b978d4b0d24a0a55e0d86e8e3c899575";
        if (targetFinder.startInit(kAccessKey, kSecretKey)) {
            targetFinder.waitUntilInitFinished();
        }


        int resultCode = targetFinder.getInitState();
        if (resultCode != TargetFinder.INIT_SUCCESS) {
            if (resultCode == TargetFinder.INIT_ERROR_NO_NETWORK_CONNECTION) {
                mInitErrorCode = UPDATE_ERROR_NO_NETWORK_CONNECTION;
            } else {
                mInitErrorCode = UPDATE_ERROR_SERVICE_NOT_AVAILABLE;
            }

            Log.e(LOGTAG, "Failed to initialize target finder.");
            return false;
        }

        return true;

////         Create the data sets:
//        dataSetStonesAndChips = objectTracker.createDataSet();
//        if (dataSetStonesAndChips == null) {
//            Log.d(LOGTAG, "Failed to create a new tracking data.");
//            return false;
//        }
//
//        // Load the data sets:
//        if (!dataSetStonesAndChips.load("StonesAndChips.xml",
//                STORAGE_TYPE.STORAGE_APPRESOURCE)) {
//            Log.d(LOGTAG, "Failed to load data set.");
//            return false;
//        }
//
//        // Activate the data set:
//        if (!objectTracker.activateDataSet(dataSetStonesAndChips)) {
//            Log.d(LOGTAG, "Failed to activate data set.");
//            return false;
//        }
//
//        Log.d(LOGTAG, "Successfully loaded and activated data set.");
//
//        return true;
    }


    @Override
    public boolean doStartTrackers() {
        // Indicate if the trackers were started correctly
        boolean result = true;

        TrackerManager trackerManager = TrackerManager.getInstance();
        ObjectTracker objectTracker = (ObjectTracker) trackerManager
                .getTracker(ObjectTracker.getClassType());
        objectTracker.start();

        // Start cloud based recognition if we are in scanning mode:
        TargetFinder targetFinder = objectTracker.getTargetFinder();
        targetFinder.startRecognition();
        scanlineStart();
        mFinderStarted = true;

//        Tracker objectTracker = TrackerManager.getInstance().getTracker(
//                ObjectTracker.getClassType());
        objectTracker.start();
        Vuforia.setHint(HINT.HINT_MAX_SIMULTANEOUS_IMAGE_TARGETS, 1);

        return result;
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
    public boolean doUnloadTrackersData() {
//            // Indicate if the trackers were unloaded correctly
//            boolean result = true;
//
//            // Get the image tracker:
//            TrackerManager trackerManager = TrackerManager.getInstance();
//            ObjectTracker objectTracker = (ObjectTracker) trackerManager
//                    .getTracker(ObjectTracker.getClassType());
//            if (objectTracker == null) {
//                Log.d(
//                        LOGTAG,
//                        "Failed to destroy the tracking data set because the ObjectTracker has not been initialized.");
//                return false;
//            }
//
//            if (dataSetStonesAndChips != null) {
//                if (objectTracker.getActiveDataSet() == dataSetStonesAndChips
//                        && !objectTracker.deactivateDataSet(dataSetStonesAndChips)) {
//                        && !objectTracker.deactivateDataSet(dataSetStonesAndChips)) {
//                    Log.d(
//                            LOGTAG,
//                            "Failed to destroy the tracking data set StonesAndChips because the data set could not be deactivated.");
//                    result = false;
//                } else if (!objectTracker.destroyDataSet(dataSetStonesAndChips)) {
//                    Log.d(LOGTAG,
//                            "Failed to destroy the tracking data set StonesAndChips.");
//                    result = false;
//                }
//+3

//                dataSetStonesAndChips = null;
//            }
//
//            return result;
        // Deinitialize Cloud Reco
        // Get the object tracker:
        TrackerManager trackerManager = TrackerManager.getInstance();
        ObjectTracker objectTracker = (ObjectTracker) trackerManager
                .getTracker(ObjectTracker.getClassType());
        TargetFinder finder = objectTracker.getTargetFinder();
        finder.deinit();
        return true;
    }


    @Override
    public boolean doDeinitTrackers() {
        // Indicate if the trackers were deinitialized correctly
        boolean result = true;

        // Deinit the image tracker:
        TrackerManager trackerManager = TrackerManager.getInstance();
        trackerManager.deinitTracker(ObjectTracker.getClassType());

        return result;
    }


    @Override
    public void onInitARDone(SampleApplicationException exception) {

        if (exception == null) {
            initApplicationAR();

            mRenderer.mIsActive = true;

            // Now add the GL surface view. It is important
            // that the OpenGL ES surface view gets added
            // BEFORE the camera is started and video
            // background is configured.
            addContentView(mGlView, new LayoutParams(LayoutParams.MATCH_PARENT,
                    LayoutParams.MATCH_PARENT));

            // Sets the UILayout to be drawn in front of the camera
            mUILayout.bringToFront();

            // Hides the Loading Dialog
            loadingDialogHandler
                    .sendEmptyMessage(LoadingDialogHandler.HIDE_LOADING_DIALOG);

            // Sets the layout background to transparent
            mUILayout.setBackgroundColor(Color.TRANSPARENT);

            try {
                vuforiaAppSession.startAR(CameraDevice.CAMERA_DIRECTION.CAMERA_DIRECTION_DEFAULT);
            } catch (SampleApplicationException e) {
                Log.e(LOGTAG, e.getString());
            }

            boolean result = CameraDevice.getInstance().setFocusMode(
                    CameraDevice.FOCUS_MODE.FOCUS_MODE_CONTINUOUSAUTO);

            if (!result)
                Log.e(LOGTAG, "Unable to enable continuous autofocus");

//            Create Menu
//            mSampleAppMenu = new SampleAppMenu(this, this, "Video Playback",
//                    mGlView, mUILayout, null);
//            setSampleAppMenuSettings();

            mIsInitialized = true;

        } else {
            Log.e(LOGTAG, exception.getString());
            if (mInitErrorCode != 0) {
                showErrorMessage(mInitErrorCode, 10, true);
            } else {
                showInitializationErrorMessage(exception.getString());
            }
            showInitializationErrorMessage(exception.getString());
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
                        VideoPlayback.this);
                builder
                        .setMessage(
                                getStatusDescString(VideoPlayback.this.mlastErrorCode))
                        .setTitle(
                                getStatusTitleString(VideoPlayback.this.mlastErrorCode))
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
                        VideoPlayback.this);
                builder
                        .setMessage(errorMessage)
                        .setTitle(getString(R.string.INIT_ERROR))
                        .setCancelable(false)
                        .setIcon(0)
                        .setPositiveButton("OK",
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
        }
    }


    @Override
    public void onVuforiaUpdate(State state) {

    }

    final private static int CMD_BACK = -1;
    final private static int CMD_FULLSCREEN_VIDEO = 1;


    // This method sets the menu's settings
    private void setSampleAppMenuSettings() {
        SampleAppMenuGroup group;

        group = mSampleAppMenu.addGroup("", false);
        group.addTextItem(getString(R.string.menu_back), -1);

        group = mSampleAppMenu.addGroup("", true);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.ICE_CREAM_SANDWICH) {
            group.addSelectionItem(getString(R.string.menu_playFullscreenVideo),
                    CMD_FULLSCREEN_VIDEO, mPlayFullscreenVideo);
        }

        mSampleAppMenu.attachMenu();
    }


    @Override
    public boolean menuProcess(int command) {

        boolean result = true;

        switch (command) {
            case CMD_BACK:
                finish();
                break;

            case CMD_FULLSCREEN_VIDEO:
                mPlayFullscreenVideo = !mPlayFullscreenVideo;

                for (int i = 0; i < mVideoPlayerHelper.length; i++) {
                    if (mVideoPlayerHelper[i].getStatus() == MEDIA_STATE.PLAYING) {
                        // If it is playing then we pause it
                        mVideoPlayerHelper[i].pause();

                        mVideoPlayerHelper[i].play(true,
                                mSeekPosition[i]);
                    }
                }
                break;
        }

        return result;
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

    public void toastMe(String mess) {
        Toast.makeText(mActivity, mess, Toast.LENGTH_SHORT).show();
    }

    public void targetLost() {
        try {
            if (mediaPlayer != null && mediaPlayer.isPlaying()) {
                btnAudio.setVisibility(View.VISIBLE);
            } else {
                btnAudio.setVisibility(View.INVISIBLE);
            }
        } catch (IllegalStateException ex) {
            btnAudio.setVisibility(View.INVISIBLE);
        }

        btnVideo.setVisibility(View.INVISIBLE);

        //check = -1;
    }

    public void targetFound() {

        btnAudio.setVisibility(View.VISIBLE);
        btnVideo.setVisibility(View.VISIBLE);
    }

    public void play(String u) {
        String url = u;
        mediaPlayer = new MediaPlayer();
        mediaPlayer.setAudioStreamType(AudioManager.STREAM_MUSIC);
        try {
            mediaPlayer.setDataSource(url);

            mediaPlayer.prepare(); // might take long! (for buffering, etc)

            Toast.makeText(this, String.valueOf(mediaPlayer.isPlaying()), Toast.LENGTH_SHORT).show();
        } catch (Exception e) {
            Log.d("ExceptionME", e.getMessage() + "");
        }
        mediaPlayer.start();
    }

    public void stop() {
        if (mediaPlayer != null)
            mediaPlayer.pause();
    }

    public void pause() {
        if (mediaPlayer != null && mediaPlayer.isPlaying()) {
            mediaPlayer.pause();
            isplaying = false;
        } else if (mediaPlayer != null && !mediaPlayer.isPlaying()) {
            mediaPlayer.start();

        }
    }


}
