package com.example.ben.sosheartv4;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import org.achartengine.ChartFactory;
import org.achartengine.GraphicalView;
import org.achartengine.model.XYMultipleSeriesDataset;
import org.achartengine.model.XYSeries;
import org.achartengine.renderer.XYMultipleSeriesRenderer;
import org.achartengine.renderer.XYSeriesRenderer;
import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;


public class PatientStateActivity extends Activity {
    TextView name,state,arrhythmia,activity;
    String ar="",s;
    Button call,tip;
    ProgressDialog pDialog;

    HttpRequest request=new HttpRequest();
    String url="http://192.168.100.7/Real3/detail.php";

    LinearLayout chart;
    XYSeriesRenderer heartbeat;
    XYSeries heartbeatSeries;
    XYMultipleSeriesDataset mySeries;
    XYMultipleSeriesRenderer myRenderer;
    GraphicalView myChart;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_patient_state);
        Intent intent=getIntent();
        name=(TextView) findViewById(R.id.apsTVName);
        name.setText(intent.getStringExtra("name"));
        s=intent.getStringExtra("state");

        state=(TextView) findViewById(R.id.apsTVState);
        state.setText("State:\n"+s);
        arrhythmia=(TextView) findViewById(R.id.apsTVArrhythmia);
        activity=(TextView) findViewById(R.id.apsTVActivity);
        call=(Button) findViewById(R.id.apsBCall);
        tip=(Button) findViewById(R.id.apsBTips);

        if(!s.equals("danger")){
            arrhythmia.setVisibility(View.GONE);
            call.setVisibility(View.GONE);
            tip.setVisibility(View.GONE);
        }

        chart=(LinearLayout) findViewById(R.id.chart);
        initializeChart();
        myChart= ChartFactory.getLineChartView(this, mySeries, myRenderer);
        // Add chart to the layout
        chart.addView(myChart);

        new PSAAsyncTask().execute();
    }



    public void ActionAPState(View v){
        Intent intent;
        switch (v.getId()){
            case R.id.apsBCall:
                intent = new Intent(Intent.ACTION_CALL, Uri.parse("tel:" + "998"));
                startActivity(intent);
                break;
            case R.id.apsBTips:
                 intent=new Intent(this,TipsActivity.class);

                intent.putExtra("arrhythmia",ar);
                startActivity(intent);
                break;
            case R.id.apsBUpdate:
                new PSAAsyncTask().execute();
                break;
        }
    }


    private void initializeChart()
    {
        heartbeat=new XYSeriesRenderer();
        // Set color for each series
        heartbeat.setColor(Color.RED);
        // Create XYMultipleSeriesRenderer
        myRenderer=new XYMultipleSeriesRenderer();
        // Add renderers to XYMultipleSeriesRenderer
        myRenderer.addSeriesRenderer(heartbeat);
        // Disable panning
        myRenderer.setPanEnabled(false);
        myRenderer.setZoomButtonsVisible(false);
        // Initialize series
        heartbeatSeries=new XYSeries("heartbeat");
        // Create XYMultipleSeriesDataset
        mySeries=new XYMultipleSeriesDataset();
        // Add series to XYMultipleSeriesDataset
        mySeries.addSeries(heartbeatSeries);
    }

    public void callAlert(final String title,String message){
        AlertDialog.Builder alert=new AlertDialog.Builder(this);
        alert.setTitle(title);
        alert.setMessage(message);

        alert.setNegativeButton("OK",new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {

            }
        });
        alert.show();
    }

    public class PSAAsyncTask extends AsyncTask<String ,String,String>{

        @Override
        protected void onPreExecute() {
            pDialog = new ProgressDialog(PatientStateActivity.this);
            pDialog.setMessage("Connection To Server..");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... params) {
            List<NameValuePair> post=new ArrayList<NameValuePair>();
            post.add(new BasicNameValuePair("name",name.getText().toString()));
            try{
                JSONObject jsonObject=request.requestToPHP(url,"POST",post);
                Log.v("jsonObject:",jsonObject.toString());
                if (jsonObject.getInt("success")==1){
                    state.setText("State:\n" + jsonObject.getString("state"));
                    arrhythmia.setText("Arrhythmia:\n"+jsonObject.getString("arrhythmia"));
                    ar=jsonObject.getString("arrhythmia");
                    activity.setText("Activity:\n"+jsonObject.getString("activity"));
                    return "1";
                }else {
                    return jsonObject.getString("message");
                }
            } catch (JSONException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            return "0";
        }

        @Override
        protected void onPostExecute(String se) {

            pDialog.dismiss();
            if (!se.equals("1"))
            callAlert("Sorry",se);
        }

    }
}
