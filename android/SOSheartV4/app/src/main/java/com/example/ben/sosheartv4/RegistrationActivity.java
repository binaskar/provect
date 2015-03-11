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

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;


public class RegistrationActivity extends Activity {
    EditText user,pass1,pass2,email1,email2;
    String url="http://<write your ip>/Real2/Regsitration.php";
    private ProgressDialog pDialog;
    HttpRequest request=new HttpRequest();
    JSONParser jParser= new JSONParser();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registration);
        user=(EditText) findViewById(R.id.arETUserName);
        pass1=(EditText) findViewById(R.id.arETPassword1);
        pass2=(EditText) findViewById(R.id.arETPassword2);
        email1=(EditText) findViewById(R.id.arETEmail1);
        email2=(EditText) findViewById(R.id.arETEmail2);

    }


   public void ActionRegistrationActivity(View v){
       switch (v.getId()){
           case R.id.arBCancel:
               finish();
           case R.id.arBRegistration:
            if(isInputCorrect()){
                //Send user,pass,email to server
                new RegisAsyncTask().execute();
            }
       }
   }

    public boolean isInputCorrect(){
        String u=user.getText().toString();
        String p1=pass1.getText().toString();
        String p2=pass2.getText().toString();
        String e1=email1.getText().toString();
        String e2=email2.getText().toString();

        if(u.length()>0){
            if(p1.length()>=8&&e1.length()>=8){
                if(e1.equals(e2)&&p1.equals(p2)){
                    return true;
                }else{
                    callAlert("Error","Field are not equal to re-enter field");
                    return false;
                }
            }else{
                callAlert("Error","Some Field are less 8 character");
                return false;
            }
        }else{
            callAlert("Error","You don\'t enter any character in user name ");
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

    public class RegisAsyncTask extends AsyncTask<String,String ,String>{
        @Override
        protected void onPreExecute() {
            pDialog = new ProgressDialog(RegistrationActivity.this);
            pDialog.setMessage("Connection To Server..");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... params) {
            List<NameValuePair> post=new ArrayList<>();
            post.add(new BasicNameValuePair("name",user.getText().toString()));
            post.add(new BasicNameValuePair("password",pass1.getText().toString()));
            post.add(new BasicNameValuePair("email",email1.getText().toString()));
            post.add(new BasicNameValuePair("type","careTaker"));
            try {
                //JSONObject jsonObject=jParser.makeHttpRequest(url,"POST",post);
                JSONObject jsonObject=request.requestToPHP(url,"POST",post);
                Log.v("respnse","JSON: "+jsonObject.toString());
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
