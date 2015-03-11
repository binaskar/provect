package com.example.ben.sosheartv4;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;


public class MainActivity extends Activity {
    EditText user,pass;
    ProgressDialog pDialog;
    HttpRequest request=new HttpRequest();
    String url="http://<write your ip>/Real2/Login.php";
    Context context=this;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        user=(EditText) findViewById(R.id.amETUserName);
        pass=(EditText) findViewById(R.id.amETPassword);
    }


   public void ActionMainActivity(View v){
       switch (v.getId()){
           case R.id.amBRegistration:
               startActivity(new Intent(this,RegistrationActivity.class));
               break;
           case R.id.amBLogin:
               new MAAsyncTask().execute();
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
                if(title.equals("Accept")){
                    Intent intent=new Intent(context,PatientListActivity.class);
                    intent.putExtra("name",user.getText().toString());
                    startActivity(intent);
                }
            }
        });
        alert.show();
    }

    public class MAAsyncTask extends AsyncTask<String ,String ,String >{
        @Override
        protected void onPreExecute() {
            pDialog = new ProgressDialog(MainActivity.this);
            pDialog.setMessage("Connection To Server..");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... params) {
            List<NameValuePair> post = new ArrayList<NameValuePair>();
            post.add(new BasicNameValuePair("name",user.getText().toString()));
            post.add(new BasicNameValuePair("password",pass.getText().toString()));

            JSONObject jsonPost = null;
            try {
                jsonPost = request.requestToPHP(url,"POST",post);
                Log.d("Single Product Details", jsonPost.toString());
                if(jsonPost.getInt("isMatched")==1){
                    return "Accept";
                }else{
                    return "Reject";
                }
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            }
            return null;

        }

        @Override
        protected void onPostExecute(String s) {
            pDialog.dismiss();
            if (s.equals("Accept")){
                callAlert("Accept",user.getText().toString()+" welcome to SOSheart");
                //finish();
            } else{
                callAlert("Reject","User name or password are incorrect");
            }
        }
    }
}
