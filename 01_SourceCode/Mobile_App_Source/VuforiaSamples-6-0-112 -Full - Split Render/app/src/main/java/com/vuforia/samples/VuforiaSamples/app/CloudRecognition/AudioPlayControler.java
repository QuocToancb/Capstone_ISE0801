package com.vuforia.samples.VuforiaSamples.app.CloudRecognition;

import android.media.AudioManager;
import android.media.MediaPlayer;
import android.util.Log;

/**
 * Created by QuocToan on 11/26/2016.
 */

public class AudioPlayControler {
    private MediaPlayer mediaPlayer;

    AudioPlayControler(MediaPlayer mediaPlayer) {
        this.mediaPlayer = mediaPlayer;
    }

    public MediaPlayer getMediaPlayer() {
        return mediaPlayer;
    }

    public void playNew(String u) {
        pauseIfPlaying();
        String url = u;
//        String url = url = "http://s1mp3.cachehn42.vcdn.vn/c4d8fe9b5cdfb581ecce/8552917280299845060?key=D2s3a-IPuVzH0JyympxBww&expires=1480265423&filename=Nguoi%20Va%20Ta%20-%20Rhymastic%20Thanh%20Huyen.mp3";
        mediaPlayer.setAudioStreamType(AudioManager.STREAM_MUSIC);
        try {
            mediaPlayer.setDataSource(url);

            mediaPlayer.prepare(); // might take long! (for buffering, etc)

        } catch (Exception e) {
            Log.d("ExceptionME", e.getMessage());
        }
        mediaPlayer.start();
    }

    public void pauseIfPlaying() {
        if (mediaPlayer != null && mediaPlayer.isPlaying()) {
            mediaPlayer.pause();
        }
    }

    public void playIfPaused() {
        if (mediaPlayer != null && !mediaPlayer.isPlaying()) {
            mediaPlayer.start();
        }
    }

    public boolean isPlaying() {
        return (mediaPlayer != null && mediaPlayer.isPlaying());
    }

    public boolean isPause() {
        return (mediaPlayer != null && !mediaPlayer.isPlaying());
    }
}
