package com.example.expensesandincome;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatDialogFragment;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.Spinner;
import java.util.Calendar;
import java.util.Date;

public class AddExpenses extends AppCompatDialogFragment {

    View view;
    int amount;
    String typeOfExpense;
    EditText  date;
    //String dateString;
    EditText amountEditText;
    Spinner typeOfExpenses;
    java.sql.Date date1;

    @Override
    public Dialog onCreateDialog(Bundle savedInstanceState) {
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());

        LayoutInflater inflater = getActivity().getLayoutInflater();
        view = inflater.inflate(R.layout.add_expenses, null);

        typeOfExpenses = (Spinner) view.findViewById(R.id.typeOfExpenses);
        //typeOfExpense = getResources().getStringArray(R.array.type_of_expenses_labels)[typeOfExpenses.getSelectedItemPosition()];
        amountEditText = (EditText) view.findViewById(R.id.amountExpenses);
        date = (EditText) view.findViewById(R.id.dateExpenses);
        final Calendar myCalendar = Calendar.getInstance();




        //set date in layout
        TextWatcher tw = new TextWatcher() {
            private String current = "";
            private String ddmmyyyy = "DDMMYYYY";
            private Calendar cal = Calendar.getInstance();

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                if (!s.toString().equals(current)) {
                    String clean = s.toString().replaceAll("[^\\d.]|\\.", "");
                    String cleanC = current.replaceAll("[^\\d.]|\\.", "");

                    int cl = clean.length();
                    int sel = cl;
                    for (int i = 2; i <= cl && i < 6; i += 2) {
                        sel++;
                    }
                    //Fix for pressing delete next to a forward slash
                    if (clean.equals(cleanC)) sel--;

                    if (clean.length() < 8){
                        clean = clean + ddmmyyyy.substring(clean.length());
                    }else{
                        //This part makes sure that when we finish entering numbers
                        //the date is correct, fixing it otherwise
                        int day  = Integer.parseInt(clean.substring(0,2));
                        int mon  = Integer.parseInt(clean.substring(2,4));
                        int year = Integer.parseInt(clean.substring(4,8));

                        mon = mon < 1 ? 1 : mon > 12 ? 12 : mon;
                        cal.set(Calendar.MONTH, mon-1);
                        year = (year<1900)?1900:(year>2100)?2100:year;
                        cal.set(Calendar.YEAR, year);
                        // ^ first set year for the line below to work correctly
                        //with leap years - otherwise, date e.g. 29/02/2012
                        //would be automatically corrected to 28/02/2012

                        day = (day > cal.getActualMaximum(Calendar.DATE))? cal.getActualMaximum(Calendar.DATE):day;
                        clean = String.format("%02d%02d%02d",day, mon, year);
                    }

                    clean = String.format("%s/%s/%s", clean.substring(0, 2),
                            clean.substring(2, 4),
                            clean.substring(4, 8));

                    sel = sel < 0 ? 0 : sel;
                    current = clean;
                    date.setText(current);
                    date.setSelection(sel < current.length() ? sel : current.length());
                }
            }

            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {}

            @Override
            public void afterTextChanged(Editable s) {}
        };

        //date.addTextChangedListener(tw);



        builder.setView(view)
                .setTitle("Add Expenses")
                .setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {

                    }
                })
                .setPositiveButton("Submit", new DialogInterface.OnClickListener() {
                    @Override
                    //get velues selected from the dialog box
                    public void onClick(DialogInterface dialog, int which) {

                        String amountString = amountEditText.toString();
                        amount = Integer.parseInt(String.valueOf(amountEditText.getText()));
                        String dateString = date.getText().toString();
                        typeOfExpense = getResources().getStringArray(R.array.type_of_expenses_labels)[typeOfExpenses.getSelectedItemPosition()];

                        Intent insert_expenses_db = new Intent((Context)getActivity(),AddExpensesDb.class);
                        insert_expenses_db.putExtra("amount", amount)
                                .putExtra("type",typeOfExpense)
                                .putExtra("date", dateString);
                        startActivity(insert_expenses_db);


                    }
                });
        return builder.create();

    }
}
