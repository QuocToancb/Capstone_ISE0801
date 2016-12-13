
package com.TEG.app;


import android.app.Activity;
import android.app.AlertDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.ActivityInfo;
import android.content.res.Configuration;
import android.media.AudioManager;
import android.media.MediaPlayer;
import android.media.MediaPlayer.OnCompletionListener;
import android.media.MediaPlayer.OnErrorListener;
import android.media.MediaPlayer.OnPreparedListener;
import android.media.MediaPlayer.OnVideoSizeChangedListener;
import android.os.Bundle;
import android.util.Log;
import android.view.GestureDetector;
import android.view.GestureDetector.OnDoubleTapListener;
import android.view.GestureDetector.SimpleOnGestureListener;
import android.view.MotionEvent;
import android.view.SurfaceHolder;
import android.view.View;
import android.widget.MediaController;
import android.widget.VideoView;

import com.TEG.R;

import java.util.concurrent.locks.ReentrantLock;


public class FullscreenPlayback extends Activity implements OnPreparedListener,
        SurfaceHolder.Callback, OnVideoSizeChangedListener, OnErrorListener,
        OnCompletionListener {
    private static final String LOGTAG = "FullscreenPlayback";

    private VideoView mVideoView = null;
    private MediaPlayer mMediaPlayer = null;
    private SurfaceHolder mHolder = null;
    private MediaController mMediaController = null;
    private String videoLink = "";
    private int mRequestedOrientation = ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE;
    private GestureDetector mGestureDetector = null;
    private boolean mShouldPlayImmediately = false;
    private SimpleOnGestureListener mSimpleListener = null;
    private ReentrantLock mMediaPlayerLock = null;
    private ReentrantLock mMediaControllerLock = null;
    LockedScreenReceiver mLockedScreenReceiver;

    private AlertDialog mErrorDialog;

    // Prepare the view for the media player
    protected void prepareViewForMediaPlayer() {
        mVideoView = (VideoView) findViewById(R.id.surface_view);

        setRequestedOrientation(mRequestedOrientation);

        mHolder = mVideoView.getHolder();
        mHolder.addCallback(this);
    }


    protected void onCreate(Bundle savedInstanceState) {
        Log.d(LOGTAG, "onCreate");
        super.onCreate(savedInstanceState);

        setContentView(R.layout.fullscreen_layout);

        // Create the locks:
        mMediaControllerLock = new ReentrantLock();
        mMediaPlayerLock = new ReentrantLock();

        prepareViewForMediaPlayer();

        // Get data from Intent
        videoLink = getIntent().getStringExtra("videoLink");
        mRequestedOrientation = getIntent().getIntExtra("requestedOrientation",
                0);
        mShouldPlayImmediately = getIntent().getBooleanExtra(
                "shouldPlayImmediately", false);

        // Create a gesture detector that will handle single and double taps:
        mSimpleListener = new SimpleOnGestureListener();
        mGestureDetector = new GestureDetector(getApplicationContext(),
                mSimpleListener);

        // We assign the actions for the single and double taps:
        mGestureDetector.setOnDoubleTapListener(new OnDoubleTapListener() {
            public boolean onDoubleTap(MotionEvent e) {
                return false;
            }


            public boolean onDoubleTapEvent(MotionEvent e) {
                return false;
            }


            public boolean onSingleTapConfirmed(MotionEvent e) {
                boolean result = false;
                mMediaControllerLock.lock();
                // This simply toggles the MediaController visibility:
                if (mMediaController != null) {
                    if (mMediaController.isShowing())
                        mMediaController.hide();
                    else
                        mMediaController.show();

                    result = true;
                }
                mMediaControllerLock.unlock();

                return result;
            }
        });

        IntentFilter filter = new IntentFilter(Intent.ACTION_SCREEN_OFF);
        mLockedScreenReceiver = new LockedScreenReceiver();
        registerReceiver(mLockedScreenReceiver, filter);

    }


    // This is the call that actually creates the media player
    private void createMediaPlayer() {
        mMediaPlayerLock.lock();
        mMediaControllerLock.lock();

        try {
            // Create the MediaPlayer and its controller:
            mMediaPlayer = new MediaPlayer();
            mMediaController = new MediaController(this);

            mMediaPlayer.setDataSource(videoLink);
//            mMediaPlayer.setDataSource("https://s13.tenlua.vn/dl/503bb471a6592805196b712365e9789f2636addfaf4cf55be837cf60db534c10343e65fcff2f69f05469f6fb0a76471e043212d5baf51b787143801fbcd99bc490daa9cc8e0493fff93a3703fe0a947bc14acd22aa571b6d8e0628cc1f7845bfa76bf87a4d502ce3949fa22432778929b370b21a5b00606d567b3584c1a4fb75a989006c7338d3956b2f9f6e96c766dda059149ff94385c291d749b38da0c79081cee9/everything-but-the-girl-downtown-train.mp4");

            Log.d("playvideo", "After setDatasource success");
            mMediaPlayer.setDisplay(mHolder);
            mMediaPlayer.prepareAsync();
            mMediaPlayer.setOnPreparedListener(this);
            mMediaPlayer.setOnVideoSizeChangedListener(this);
            mMediaPlayer.setOnErrorListener(this);
            mMediaPlayer.setOnCompletionListener(this);
            mMediaPlayer.setAudioStreamType(AudioManager.STREAM_MUSIC);

        } catch (Exception e) {
            Log.e(LOGTAG,
                    "Error while creating the MediaPlayer: " + e.toString());

            // If have Exception, prepare for termination Activity
            prepareForTermination();
            destroyMediaPlayer();
            finish();
        }

        mMediaControllerLock.unlock();
        mMediaPlayerLock.unlock();
    }


    // Handle the touch event
    public boolean onTouchEvent(MotionEvent event) {
        return mGestureDetector.onTouchEvent(event);
    }


    // This is a callback we receive when the media player is ready to start
    // playing
    public void onPrepared(MediaPlayer mediaplayer) {
        Log.d(LOGTAG, "Fullscreen.onPrepared");

        mMediaControllerLock.lock();
        mMediaPlayerLock.lock();

        if ((mMediaController != null) && (mVideoView != null)
                && (mMediaPlayer != null)) {
            if (mVideoView.getParent() != null) {
                // We attach the media controller to the player:
                mMediaController.setMediaPlayer(player_interface);

                // Add the media controller to the view:
                View anchorView = mVideoView.getParent() instanceof View ? (View) mVideoView
                        .getParent() : mVideoView;
                mMediaController.setAnchorView(anchorView);
                mVideoView.setMediaController(mMediaController);
                mMediaController.setEnabled(true);


                // If the client requests that we play immediately
                // we tell the media player to start:
                if (mShouldPlayImmediately) {
                    try {
                        mMediaPlayer.start();
                        mShouldPlayImmediately = false;
                    } catch (Exception e) {
                        mMediaPlayerLock.unlock();
                        mMediaControllerLock.unlock();
                        Log.e(LOGTAG, "Could not start playback");
                    }
                }

                // Show briefly the controls:
                mMediaController.show();
            }
        }

        mMediaPlayerLock.unlock();
        mMediaControllerLock.unlock();
    }


    // Called when we wish to release the resources of the media player
    private void destroyMediaPlayer() {
        // Release the Media Controller:
        mMediaControllerLock.lock();
        if (mMediaController != null) {
            mMediaController.removeAllViews();
            mMediaController = null;
        }
        mMediaControllerLock.unlock();

        // Release the MediaPlayer:
        mMediaPlayerLock.lock();
        if (mMediaPlayer != null) {
            try {
                mMediaPlayer.stop();
            } catch (Exception e) {
                mMediaPlayerLock.unlock();
                Log.e(LOGTAG, "Could not stop playback");
            }
            mMediaPlayer.release();
            mMediaPlayer = null;
        }
        mMediaPlayerLock.unlock();
    }


    // Called when the app is destroyed
    protected void onDestroy() {
        // Log.d( LOGTAG, "Fullscreen.onDestroy");

        // Prepare the media player for termination:
        prepareForTermination();

        super.onDestroy();

        // Release the resources of the media player:
        destroyMediaPlayer();

        mMediaPlayerLock = null;
        mMediaControllerLock = null;

    }

    // Called when the app is resumed
    protected void onResume() {
        Log.d(LOGTAG, "onResume");
        super.onResume();

        // Prepare a view that the media player can use:
        prepareViewForMediaPlayer();

        if (mLockedScreenReceiver.wasLocked()) {
            createMediaPlayer();

            if (mMediaController != null)
                mMediaController.show();

            mLockedScreenReceiver.setLocked(false);
        }
    }


    // Called when the activity configuration has changed
    public void onConfigurationChanged(Configuration config) {
        super.onConfigurationChanged(config);
    }


    // This is called when we should prepare the media player and the
    // activity for termination
    private void prepareForTermination() {
        // First we prepare the controller:
        mMediaControllerLock.lock();
        if (mMediaController != null) {
            mMediaController.hide();
            mMediaController.removeAllViews();
        }
        mMediaControllerLock.unlock();

        // Then the MediaPlayer:
        mMediaPlayerLock.lock();
        if (mMediaPlayer != null) {

            // We store the playback mode of the movie:
            boolean wasPlaying = mMediaPlayer.isPlaying();
            if (wasPlaying) {
                try {
                    mMediaPlayer.pause();
                } catch (Exception e) {
                    mMediaPlayerLock.unlock();
                    Log.e(LOGTAG, "Could not pause playback");
                }
            }

            // This activity was started for result, thus we need to return
            // whether it was playing and in which position:
            Intent i = new Intent();
            i.putExtra("videoLink", videoLink);
            i.putExtra("playing", wasPlaying);
            setResult(Activity.RESULT_OK, i);

        }
        mMediaPlayerLock.unlock();
    }


    public void onBackPressed() {
        // Request the media player to prepare for termination:
        prepareForTermination();
        Intent j = new Intent();
        j.setClassName(getPackageName(), getPackageName() + "." + "app.TEGa.CloudReco");
        startActivity(j);
        super.onBackPressed();
    }


    // Called when the activity is paused
    protected void onPause() {
        Log.d(LOGTAG, "Fullscreen.onPause");
        super.onPause();

        // We first prepare for termination:
        prepareForTermination();

        // Request the release of resource of the media player:
        destroyMediaPlayer();
    }


    // Called when the surface is changed
    public void surfaceCreated(SurfaceHolder holder) {
        // Request the creation of a media player:
        createMediaPlayer();
    }


    // Called when the surface is changed
    public void surfaceChanged(SurfaceHolder holder, int format, int width,
                               int height) {
    }


    // Called when the surface is destroyed
    public void surfaceDestroyed(SurfaceHolder holder) {
    }

    // The following are the predefined methods of the MediaPlayerController
    // We simply forward the values to/from the MediaPlayer
    private MediaController.MediaPlayerControl player_interface = new MediaController.MediaPlayerControl() {
        // Returns the current buffering percentage
        public int getBufferPercentage() {
            return 100;
        }


        // Returns the current seek position
        public int getCurrentPosition() {
            int result = 0;
            mMediaPlayerLock.lock();
            if (mMediaPlayer != null)
                result = mMediaPlayer.getCurrentPosition();
            mMediaPlayerLock.unlock();
            return result;
        }


        // Returns the duration of the movie
        public int getDuration() {
            int result = 0;
            mMediaPlayerLock.lock();
            if (mMediaPlayer != null)
                result = mMediaPlayer.getDuration();
            mMediaPlayerLock.unlock();
            return result;
        }


        // Returns whether the movie is currently playing
        public boolean isPlaying() {
            boolean result = false;

            mMediaPlayerLock.lock();
            if (mMediaPlayer != null)
                result = mMediaPlayer.isPlaying();
            mMediaPlayerLock.unlock();
            return result;
        }


        // Pauses the current playback
        public void pause() {
            mMediaPlayerLock.lock();
            if (mMediaPlayer != null) {
                try {
                    mMediaPlayer.pause();
                } catch (Exception e) {
                    mMediaPlayerLock.unlock();
                    Log.e(LOGTAG, "Could not pause playback");
                }
            }
            mMediaPlayerLock.unlock();
        }


        // Seeks to the required position
        public void seekTo(int pos) {
            mMediaPlayerLock.lock();
            if (mMediaPlayer != null) {
                try {
                    mMediaPlayer.seekTo(pos);
                } catch (Exception e) {
                    mMediaPlayerLock.unlock();
                    Log.e(LOGTAG, "Could not seek to position");
                }
            }
            mMediaPlayerLock.unlock();
        }


        // Starts the playback of the movie
        public void start() {
            mMediaPlayerLock.lock();
            if (mMediaPlayer != null) {
                try {
                    mMediaPlayer.start();
                } catch (Exception e) {
                    mMediaPlayerLock.unlock();
                    Log.e(LOGTAG, "Could not start playback");
                }
            }
            mMediaPlayerLock.unlock();
        }


        // Returns whether the movie can be paused
        public boolean canPause() {
            return true;
        }


        // Returns whether the movie can seek backwards
        public boolean canSeekBackward() {
            return true;
        }


        // Returns whether the movie can seek forwards
        public boolean canSeekForward() {
            return true;
        }


        public int getAudioSessionId() {
            return 0;
        }
    };


    public void onVideoSizeChanged(MediaPlayer mp, int width, int height) {
    }


    public boolean onError(MediaPlayer mp, int what, int extra) {
        if (mp == mMediaPlayer) {
            String errorDescription;

            switch (what) {
                case MediaPlayer.MEDIA_ERROR_NOT_VALID_FOR_PROGRESSIVE_PLAYBACK:
                    errorDescription = "Video có chứa dữ liệu lỗi trong quá trình phát";
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

            showErrorMessageJson("Lỗi trình chiếu video", errorDescription + "/nVui lòng thử lại sau", true);

            Log.e(LOGTAG, "Error while opening the file for fullscreen. "
                    + "Unloading the media player (" + errorDescription + ", "
                    + extra + ")");

            prepareForTermination();

            destroyMediaPlayer();

            return true;
        }

        return false;
    }


    @Override
    public void onCompletion(MediaPlayer mp) {
        prepareForTermination();
        finish();
    }

    class LockedScreenReceiver extends BroadcastReceiver {

        boolean wasLocked = false;

        @Override
        public void onReceive(Context context, Intent intent) {
            if (intent.getAction().equals(Intent.ACTION_SCREEN_OFF)) {
                wasLocked = true;
            }
        }

        public boolean wasLocked() {
            return wasLocked;
        }

        public void setLocked(boolean isLocked) {
            wasLocked = isLocked;
        }

    }

    public void showErrorMessageJson(final String title, final String message, final boolean finishActivityOnError) {


        runOnUiThread(new Runnable() {
            public void run() {
                if (mErrorDialog != null) {
                    mErrorDialog.dismiss();
                }

                // Generates an Alert Dialog to show the error message
                AlertDialog.Builder builder = new AlertDialog.Builder(
                        FullscreenPlayback.this);
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
