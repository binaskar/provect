package com.example.ben.sosheartv4;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;


public class TipsActivity extends Activity {
    TextView arrhythmia,tips;

    HttpRequest request=new HttpRequest();
    String url="http://192.168.100.18/Real2/tip.php",arr;

    ProgressDialog pDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tips);
        arrhythmia=(TextView) findViewById(R.id.atTVArrhythmia);
        Intent intent=getIntent();
        arr=intent.getStringExtra("arrhythmia");
       arrhythmia.setText(intent.getStringExtra("arrhythmia"));
        tips=(TextView) findViewById(R.id.atTVTips);
        new TAAsyncTask().execute();

    }

    public class TAAsyncTask extends AsyncTask<String,String,String>{
        @Override
        protected void onPreExecute() {
            pDialog = new ProgressDialog(TipsActivity.this);
            pDialog.setMessage("Connection To Server..");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... params) {
            List<NameValuePair> post=new ArrayList<NameValuePair>();
            post.add(new BasicNameValuePair("arrhythmia",arr));
            try{
                JSONObject jsonObject=request.requestToPHP(url,"POST",post);
                Log.d("JSON","Response:"+jsonObject.toString());
                if(jsonObject.getInt("success")==1){
                    tips.setText(jsonObject.getString("tips"));
                }

            } catch (JSONException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return "";
        }

        @Override
        protected void onPostExecute(String s) {
            pDialog.dismiss();
        }
    }



}
