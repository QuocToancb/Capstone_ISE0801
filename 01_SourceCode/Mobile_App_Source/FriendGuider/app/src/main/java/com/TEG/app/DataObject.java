package com.TEG.app;


/**
 * Created by QuocToan on 11/27/2016.
 */

public class DataObject {

    private String targetName = "";
    private String audioLink = "";
    private String videoLink = "";

    public DataObject() {
        this.targetName = "";
        this.audioLink = "";
        this.videoLink = "";
    }

    public DataObject(String targetName) {
        this.targetName = targetName;
    }

    public DataObject(String targetName, String audioLink, String videoLink) {
        this.targetName = targetName;
        this.audioLink = audioLink;
        this.videoLink = videoLink;
    }

    public String getTargetName() {
        return targetName;
    }

    public String getAudioLink() {
        return audioLink;
    }

    public String getVideoLink() {
        return videoLink;
    }
}

