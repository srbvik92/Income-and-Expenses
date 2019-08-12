package com.example.expensesandincome;

import android.net.Uri;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

public class HomeFragment extends Fragment implements IncomeWebView.OnFragmentInteractionListener, ExpensesWebView.OnFragmentInteractionListener {

    View HomeView;
    Button addExpenses;
    Button addIncome;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        //return inflater.inflate(R.layout.activity_home, container, false);

        HomeView = inflater.inflate(R.layout.activity_home, container, false);

        addExpenses = (Button)HomeView.findViewById(R.id.addExpenses);
        addIncome = (Button) HomeView.findViewById(R.id.addIncome);

        addExpenses.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AddExpenses addExpenses = new AddExpenses();
                addExpenses.show(getFragmentManager(),"Add Expenses");
            }
        });

        addIncome.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AddIncome addIncome = new AddIncome();
                addIncome.show(getFragmentManager(), "Add Income");
            }
        });

        return HomeView;
    }

    @Override
    public void onFragmentInteraction(Uri uri) {

    }
}
