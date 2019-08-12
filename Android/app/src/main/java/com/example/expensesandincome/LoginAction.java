package com.example.expensesandincome;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.Iterator;

import javax.net.ssl.HttpsURLConnection;

public class LoginAction extends AppCompatActivity {

    String username;
    String pass;
    String line;
    String code;
    Intent in;
    boolean rememberMe;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        in = getIntent();
        username = (String) in.getStringExtra("username");
        pass = (String) in.getStringExtra("pass");

        if(in.hasExtra("remember me")){
            rememberMe = true;
        }
        else{
            rememberMe = false;
        }

        new SendPostRequest().execute();

    }

    public class SendPostRequest extends AsyncTask<String, Void, String> {

        protected void onPreExecute(){}

        protected String doInBackground(String... arg0) {

            try {

                URL url = new URL(Variables.servername+"android/login_action_android.php"); // here is your URL path

                JSONObject postDataParams = new JSONObject();
                postDataParams.put("uname",username);
                postDataParams.put("pass",pass);
                Log.e("params",postDataParams.toString());

                HttpURLConnection conn = (HttpURLConnection) url.openConnection();
                conn.setReadTimeout(15000 /* milliseconds */);
                conn.setConnectTimeout(15000 /* milliseconds */);
                conn.setRequestMethod("POST");
                conn.setDoInput(true);
                conn.setDoOutput(true);

                OutputStream os = conn.getOutputStream();
                BufferedWriter writer = new BufferedWriter(
                        new OutputStreamWriter(os, "UTF-8"));
                writer.write(getPostDataString(postDataParams));

                writer.flush();
                writer.close();
                os.close();

                int responseCode=conn.getResponseCode();

                Log.e("http response code", conn.getResponseMessage());

                if (responseCode == HttpsURLConnection.HTTP_OK) {

                    Log.e("inside if", "OK");

                    BufferedReader in=new BufferedReader(new
                            InputStreamReader(
                            conn.getInputStream()));

                    StringBuffer sb = new StringBuffer("");


                    while((line = in.readLine()) != null) {

                        sb.append(line);
                        break;
                    }

                    //JSONArray arr = new JSONArray(sb.toString());
                    JSONObject jObj = new JSONObject(sb.toString());
                    //String arr = new String(jObj.getString("uname"));
                    String error = jObj.getString("code");
                    code = error;

                    Log.e("code", error);
                    in.close();

                    if(error.equals("success")){
                        String uname = jObj.getString("uname");
                        Log.e("success","inside if");
                        Variables.username =  uname;

                        Intent loginSuccess = new Intent(getApplicationContext(),Navigation.class);

                        //set shared preferences to save username
                        if(rememberMe == true) {
                            //SharedPreferences sp = getApplicationContext().getSharedPreferences("com.example.expensesandincome", Context.MODE_PRIVATE);
                            SharedPreferences sp = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
                            SharedPreferences.Editor spe = sp.edit();
                            spe.putString("username", username);
                            spe.putString("loginAuthenticate", "yes");
                            spe.commit();
                            //spe.commit();
                        }
                        startActivity(loginSuccess);

                    }
                    else if (error == "username and password mismatch"){
                        Variables.loginMessage = "error";
                        //Variables.username =  uname;
                        Intent loginFailure = new Intent(getApplicationContext(),LoginActivity.class);
                        startActivity(loginFailure);
                    }
                    return sb.toString();


                }
                else {
                    return new String("false : "+responseCode);
                }
            }
            catch(Exception e){
                return new String("Exception: " + e.getMessage());
            }

        }

        @Override
        protected void onPostExecute(String result) {
            Toast.makeText(getApplicationContext(), result,
                    Toast.LENGTH_LONG).show();
            //user.setText(loginMessage);

        }
    }

    public String getPostDataString(JSONObject params) throws Exception {

        StringBuilder result = new StringBuilder();
        boolean first = true;

        Iterator<String> itr = params.keys();

        while(itr.hasNext()){

            String key= itr.next();
            Object value = params.get(key);

            if (first)
                first = false;
            else
                result.append("&");

            result.append(URLEncoder.encode(key, "UTF-8"));
            result.append("=");
            result.append(URLEncoder.encode(value.toString(), "UTF-8"));

        }
        return result.toString();
    }
}
