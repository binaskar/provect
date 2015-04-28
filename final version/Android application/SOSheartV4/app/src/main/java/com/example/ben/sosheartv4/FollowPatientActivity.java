package com.example.ben.sosheartv4;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;


public class FollowPatientActivity extends Activity {
    EditText pati;
    String url="http://192.168.100.7/Real3/patient_list.php";
    private ProgressDialog pDialog;
    HttpRequest request=new HttpRequest();
    String user;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_follow_patient);
        pati=(EditText)findViewById(R.id.afpETPatientName);
        Intent intent=getIntent();
        user=intent.getStringExtra("name");

    }


    public void ActionFollowPatientActivity(View v){
        String p=pati.getText().toString();
        switch (v.getId()){
            case R.id.afpBCancel:
                finish();
                break;
            case R.id.afpBFollowing:
                if(p.length()>0){

                    new FollowingAsyncTask().execute("care",user,p);
                }else{
                    callAlert("Error","You don\'t enter any character in patient name ");
                }
                break;
        }
    }

    public void callAlert(final String title,String message){
        AlertDialog.Builder alert=new AlertDialog.Builder(this);
        alert.setTitle(title);
        alert.setMessage(message);

        alert.setNegativeButton("OK",new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                finish();

            }
        });
        alert.show();

    }

    public class FollowingAsyncTask extends AsyncTask<String,String,String> {
        @Override
        protected void onPreExecute() {
            pDialog = new ProgressDialog(FollowPatientActivity.this);
            pDialog.setMessage("Connection To Server..");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... params) {
            List<NameValuePair> post = new ArrayList<NameValuePair>();
            post.add(new BasicNameValuePair("task", params[0]));
            post.add(new BasicNameValuePair("name", params[1]));
            try {
                 if(params[0].equals("care")){
                    post.add(new BasicNameValuePair("patientName", params[2]));
                    Log.d("Single POST CARE  Deta:", post.toString());
                    JSONObject jObj=request.requestToPHP(url,"POST",post);
                    Log.d("Single JSON Details", jObj.toString());
                    if(jObj.getInt("success")==1){

                        return "Accept";
                    }else{
                        return "Reject";
                    }
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
             if(s.equals("Accept")) {
                 callAlert("Success", "Now your following"+pati.getText().toString());
            }else if(s.equals("Reject")){
                callAlert("Reject", "Patient name is incorrect");
            }
        }
    }
}
