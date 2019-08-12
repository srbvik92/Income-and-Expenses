package com.example.expensesandincome;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;

public class LogoutActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        //remove the saved username
        Variables.username = "";

        SharedPreferences s = PreferenceManager.getDefaultSharedPreferences(getApplicationContext());
        s.edit().clear().commit();

        //redirect to login page
        Intent in = new Intent(LogoutActivity.this, LoginActivity.class);
        startActivity(in);
    }
}
