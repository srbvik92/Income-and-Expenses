package com.example.expensesandincome;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatDialogFragment;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.Spinner;

public class AddIncome extends AppCompatDialogFragment {

    View view;
    int amount;
    //String typeOfExpense;
    EditText date;
    //String dateString;
    EditText amountEditText;
    java.sql.Date date1;

    @Override
    public Dialog onCreateDialog(Bundle savedInstanceState) {
        //return super.onCreateDialog(savedInstanceState);
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());

        LayoutInflater inflater = getActivity().getLayoutInflater();
        view = inflater.inflate(R.layout.add_income, null);

        amountEditText = (EditText) view.findViewById(R.id.amount);
        date = (EditText) view.findViewById(R.id.date);


        builder.setView(view)
                .setTitle("Enter Income")
                .setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {

                    }
                })
                .setPositiveButton("Submit", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        amount = Integer.parseInt(String.valueOf(amountEditText.getText()));
                        String dateString = date.getText().toString();

                        Intent insert_income_db = new Intent((Context)getActivity(), AddIncomeDb.class);
                        insert_income_db.putExtra("amount", amount);
                        insert_income_db.putExtra("date", dateString);
                        startActivity(insert_income_db);
                    }
                });
        return builder.create();

    }
}

