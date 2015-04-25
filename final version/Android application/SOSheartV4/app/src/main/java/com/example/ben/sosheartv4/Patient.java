package com.example.ben.sosheartv4;

/**
 * Created by abdullah on 1/31/2015.
 */
public class Patient {

    public String getPatinetName() {
        return patinetName;
    }

    public String getState() {
        return state;
    }

    public void setState(String state) {
        this.state = state;
    }

    public void setPatinetName(String patinetName) {
        this.patinetName = patinetName;
    }



    String patinetName,state;
    public Patient(){

    }
}
