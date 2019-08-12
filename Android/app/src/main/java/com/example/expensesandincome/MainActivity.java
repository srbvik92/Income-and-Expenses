package com.example.expensesandincome;

import android.content.Intent;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;

public class MainActivity extends AppCompatActivity {

    //private static final String PREFS = "eandi";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        //SharedPreferences data = getSharedPreferences("com.example.expensesandincome", getApplicationContext().MODE_PRIVATE );

        /*String username = data.getString("username","null");

        Log.e("user", username);

        String loginAuthenticate = data.getString("loginAuthenticate", "no");

        Log.e("loginauthenticate", loginAuthenticate); */

        SharedPreferences data = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());

        String username = data.getString("username","null");

        Log.e("user", username);

        String loginAuthenticate = data.getString("loginAuthenticate", "no");

        Log.e("loginauthenticate", loginAuthenticate);


        Intent intent = new Intent();

        if (loginAuthenticate.equals("yes")) {
            intent = new Intent(MainActivity.this, Navigation.class);
        } else if (loginAuthenticate=="no") {
            intent = new Intent(MainActivity.this,
                    LoginActivity.class);
        }
        else{
            intent = new Intent(MainActivity.this,
                    LoginActivity.class);
        }

        startActivity(intent);
        this.finish();
    }
}
