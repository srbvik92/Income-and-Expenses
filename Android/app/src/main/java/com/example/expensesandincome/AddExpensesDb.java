package com.example.expensesandincome;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
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

public class AddExpensesDb extends AppCompatActivity {

    int amount;
    String typeOfExpense;
    String date;
    String line;
    TextView textView;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
       // setContentView(R.layout.add_expenses_db);

        textView = (TextView) findViewById(R.id.textView4);
        Intent in = getIntent();
        amount = in.getIntExtra("amount", 0);
        typeOfExpense = in.getStringExtra("type");
        date = in.getStringExtra("date");

        new SendPostRequest().execute();

    }

    public class SendPostRequest extends AsyncTask<String, Void, String> {

        protected void onPreExecute(){}

        protected String doInBackground(String... arg0) {

            try {
                //textView.setText(date);
                URL url = new URL("http://10.0.2.2:80/expenses/android/insert_expenses_db_android.php"); // here is your URL path

                JSONObject postDataParams = new JSONObject();
                postDataParams.put("username",Variables.username);
                postDataParams.put("amount",amount);
                postDataParams.put("type", typeOfExpense);
                postDataParams.put("date", date);
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

                if (responseCode == HttpsURLConnection.HTTP_OK) {

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
                    String code = new String(jObj.getString("code"));
                    //String uname = jObj.getString("uname");

                    if(code.equals("success")){
                        //Toast.makeText(getApplicationContext(),"successfully inserted", Toast.LENGTH_LONG);

                        Intent home = new Intent(getApplicationContext(),HomeActivity.class);
                        //home.putExtra("db_code","Inserted successfully");
                        startActivity(home);
                    }

                    in.close();
                    //user.setText(uname);
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
