package com.example.ben.sosheartv4;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;


public class PatientRegistrationActivity extends Activity {
    EditText patient,caretaker,sensor;
    String url="http://192.168.100.7/Real3/RegsitrationPatient.php";
    private ProgressDialog pDialog;
    HttpRequest request=new HttpRequest();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_patient_registration);
        patient=(EditText) findViewById(R.id.aprETPName);
        caretaker=(EditText) findViewById(R.id.aprETCName);
        sensor=(EditText) findViewById(R.id.aprETSName);
    }


    public void ActionPR(View v){
        switch (v.getId()){
            case R.id.aprBCancel:
                finish();
                break;
            case R.id.aprBRegistration:

                Log.v("RegisPatiActi: ","in action method");
                if(isInputCorrect()){
                    //Send user,pass,email to server
                    new RegisPatAsyncTask().execute();
                }
                break;
        }
    }

    public boolean isInputCorrect(){
        Log.v("RegisPatiActi: ","in isInputCorrect method, p: "+patient.getText().toString()+" , c: "+caretaker.getText().toString()+" , s: "+sensor.getText().toString());
        String p1=patient.getText().toString();
        String c1=caretaker.getText().toString();
        String s1=sensor.getText().toString();

        Log.v("RegisPatiActi: ","in isInputCorrect method, p: "+p1+" , c: "+c1+" , s: "+s1);
        if(p1.length()>0){
            if(c1.length()>0){
                if(s1.length()>0){
                    return true;
                }else{
                    callAlert("Error","You don\'t enter any character in sensor name");
                    return false;
                }
            }else{
                callAlert("Error","You don\'t enter any character in caretaker name");
                return false;
            }
        }else{
            callAlert("Error","You don\'t enter any character in patient name ");
            return false;
        }

    }

    public void callAlert(final String title,String message){
        AlertDialog.Builder alert=new AlertDialog.Builder(this);
        alert.setTitle(title);
        alert.setMessage(message);

        alert.setNegativeButton("OK",new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                if (title.equals("Accept"))
                    finish();

            }
        });
        alert.show();

    }

    public class RegisPatAsyncTask extends AsyncTask<String,String ,String> {
        @Override
        protected void onPreExecute() {
            pDialog = new ProgressDialog(PatientRegistrationActivity.this);
            pDialog.setMessage("Connection To Server..");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... params) {
            List<NameValuePair> post=new ArrayList<>();
            post.add(new BasicNameValuePair("patient",patient.getText().toString()));
            post.add(new BasicNameValuePair("caretaker",caretaker.getText().toString()));
            post.add(new BasicNameValuePair("sensor",sensor.getText().toString()));

            try {
                // JSONObject jsonObject=jParser.makeHttpRequest(url,"POST",post);
                JSONObject jsonObject=request.requestToPHP(url,"POST",post);
                Log.v("respnse", "JSON: " + jsonObject.toString());
                if (jsonObject.getInt("success")==1){
                    return "Accept";
                }else{
                    return "Reject";
                }
            } catch (JSONException e) {
                e.printStackTrace();

            } catch (IOException e) {
                e.printStackTrace();
            }

            return null;
        }

        @Override
        protected void onPostExecute(String s) {
            pDialog.dismiss();
            if (s.equals("Accept")){
                callAlert(s,"Thank you for registration in SOSHeart");
            }else {
                callAlert(s,"User name is already exist");
            }

        }
    }

}
