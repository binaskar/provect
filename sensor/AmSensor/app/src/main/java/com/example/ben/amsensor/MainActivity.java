package com.example.ben.amsensor;

import android.app.Activity;
import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.os.Bundle;

import android.util.Log;

import android.view.View;
import android.widget.Button;

import android.widget.EditText;
import android.widget.RadioButton;

import android.widget.TextView;


import org.apache.http.HttpResponse;

import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;

import org.apache.http.params.HttpConnectionParams;


import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;


public class MainActivity extends Activity {
    ProgressDialog pDialog;
    TextView respons;
    EditText start,end,min;
    Button send;
    RadioButton bytime,byarray;

    String time="",id="",dataLow1="",dataHigh1="",dataLow2="",dataHigh2="";

    String url="http://192.168.100.9/sensor/test1.php";
    JSONObject json = new JSONObject();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        respons=(TextView) findViewById(R.id.tvRespnse);
        start=(EditText) findViewById(R.id.edStart);
        end=(EditText) findViewById(R.id.edEnd);
        min=(EditText) findViewById(R.id.edMin);
        byarray=(RadioButton)findViewById(R.id.rbByarray);
        bytime=(RadioButton)findViewById(R.id.rbBytime);


        send=(Button) findViewById(R.id.bSend);
        send.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
              /*

            */
                readFile();
                preData();
                try {

                    json.put("msg", "hello");

                    JSONTransmitter transmitter = new JSONTransmitter();
                    transmitter.execute(json);

                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });

    }

    public void  readFile() {
        pDialog = new ProgressDialog(MainActivity.this);
        pDialog.setMessage("Read file..");
        pDialog.setIndeterminate(false);
        pDialog.setCancelable(true);
        pDialog.show();
        try {
            InputStream in = getAssets().open("data.txt");
            String inputString;
            BufferedReader reader = new BufferedReader(new InputStreamReader(in));
            StringBuffer stringBuffer = new StringBuffer();
            int i = 0;
            int s = Integer.parseInt(start.getText().toString());
            int e = Integer.parseInt(end.getText().toString());
            int secEnd = Integer.parseInt(min.getText().toString()) * 60;
            int secStart = (Integer.parseInt(min.getText().toString()) - 1) * 60;

            while ((inputString = reader.readLine()) != null) {
                String[] d = inputString.split("\t");

                if (byarray.isChecked()) {


                    if (i >= s && i <= e) {
                        stringBuffer.append(d[0] + "\n");
                        time += d[0] + " ";
                        id += d[1] + " ";
                        dataLow1 += d[2] + " ";
                        dataHigh1 += d[3] + " ";
                        dataLow2 += d[4] + " ";
                        dataHigh2 += d[5] + " ";

                    } else if (i > e) {
                        break;
                    }


                    i++;

                } else if (bytime.isChecked()) {

                    if (Double.parseDouble(d[0]) <= secEnd && Double.parseDouble(d[0]) >= secStart) {

                        time += d[0] + " ";
                        id += d[1] + " ";
                        dataLow1 += d[2] + " ";
                        dataHigh1 += d[3] + " ";
                        dataLow2 += d[4] + " ";
                        dataHigh2 += d[5] + " ";
                    } else {
                        break;
                    }
                }
            }

            Log.v("data: ", time +"\n"+id);
                //   respons.setText(id);
            } catch (IOException e) {
                e.printStackTrace();
            }
            pDialog.cancel();

    }

    public void preData(){
        String[] sTime=time.split(" ");
        String[] sId=id.split(" ");
        String[] sLow1=dataLow1.split(" ");
        String[] sHigh1=dataHigh1.split(" ");
        String[] sLow2=dataLow2.split(" ");
        String[] sHigh2=dataHigh2.split(" ");

        try {
            JSONArray jTime = new JSONArray();
            JSONArray jId = new JSONArray();
            JSONArray jLow1 = new JSONArray();
            JSONArray jHigh1 = new JSONArray();
            JSONArray jLow2 = new JSONArray();
            JSONArray jHigh2 = new JSONArray();
            for (int i = 0; i < sTime.length; i++) {
                jTime.put(sTime[i]);
                jId.put(sId[i]);
                jLow1.put(sLow1[i]);
                jHigh1.put(sHigh1[i]);
                jLow2.put(sLow2[i]);
                jHigh2.put(sHigh2[i]);
            }

            json.put("PatientName", "103");
            json.put("time", jTime);
            json.put("low1", jLow1);
            json.put("high1", jHigh1);
            json.put("low2", jLow2);
            json.put("high2", jHigh2);


            // JSONObject object=request.requestToPHP(url,"POST",post);

            Log.v("Send JSON: ", "JSON :" + json.toString());
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }






    public class JSONTransmitter extends AsyncTask<JSONObject, JSONObject, JSONObject> {


        @Override
        protected void onPreExecute() {
            pDialog = new ProgressDialog(MainActivity.this);
            pDialog.setMessage("Connecting to server..");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected JSONObject doInBackground(JSONObject... data) {
            JSONObject json = data[0];
            HttpClient client = new DefaultHttpClient();
            HttpConnectionParams.setConnectionTimeout(client.getParams(), 100000);

            JSONObject jsonResponse = null;
            HttpPost post = new HttpPost(url);
            try {
                StringEntity se = new StringEntity("json="+json.toString());
                post.addHeader("content-type", "application/x-www-form-urlencoded");
                post.setEntity(se);

                HttpResponse response;
                response = client.execute(post);
                String resFromServer = org.apache.http.util.EntityUtils.toString(response.getEntity());

                jsonResponse=new JSONObject(resFromServer);
                Log.i("Response from server", jsonResponse.toString());
            } catch (Exception e) { e.printStackTrace();}
            pDialog.dismiss();
            return jsonResponse;
        }

    }


}
