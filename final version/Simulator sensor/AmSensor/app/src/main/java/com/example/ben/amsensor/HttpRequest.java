package com.example.ben.amsensor;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.NameValuePair;
import org.apache.http.StatusLine;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.utils.URLEncodedUtils;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.List;

/**
 * Created by ben on 3/7/2015.
 */
public class HttpRequest {
    JSONObject jsonObject;
    public HttpRequest(){

    }

    public JSONObject requestToPHP(String url,String method,List<NameValuePair> key) throws IOException, JSONException {

        HttpClient client=new DefaultHttpClient();
        HttpEntity entity=null;
        HttpResponse response=null;
        if(method.equals("POST")){

            HttpPost post=new HttpPost(url);
            if (key != null) {
                post.setEntity(new UrlEncodedFormEntity(key));
            }
            response= client.execute(post);


        }else {
            HttpGet get=new HttpGet(url);
            if (key != null) {
                String paramString = URLEncodedUtils
                        .format(key, "utf-8");
                url += "?" + paramString;
            }
            response= client.execute(get);
        }
        StatusLine statusLine=response.getStatusLine();
        if(statusLine.getStatusCode()== HttpStatus.SC_OK){
            InputStream inputStream=response.getEntity().getContent();
            StringBuilder stringBuilder=new StringBuilder();
            BufferedReader bufferedReader=new BufferedReader(new InputStreamReader(inputStream));
            String line;
            while ((line=bufferedReader.readLine())!=null)
                if (!line.startsWith("<", 0)) {
                    if (!line.startsWith("(", 0)) {
                        stringBuilder.append(line + "\n");
                    }
                }
            String toString=stringBuilder.toString();
            jsonObject=new JSONObject(toString);
            jsonObject.put("stateLine",true);
        }else {
            response.getEntity().getContent().close();
            jsonObject.put("stateLine",false);
        }


        return jsonObject;
    }


        public static boolean checkConn(Context ctx) {
            ConnectivityManager conMgr = (ConnectivityManager) ctx
                    .getSystemService(Context.CONNECTIVITY_SERVICE);
            NetworkInfo i = conMgr.getActiveNetworkInfo();
            if (i == null&&!i.isConnected()&&!i.isAvailable()){
               // Toast.makeText(ctx, "Network Not Available", Toast.LENGTH_LONG).show();
                return false;
            }

            return true;
        }

}
