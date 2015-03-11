package com.example.ben.sosheartv4;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import java.util.ArrayList;

/**
 * Created by abdullah on 1/31/2015.
 */
public class PatientListAdapter extends ArrayAdapter<Patient> {
    ArrayList<Patient > patientList;
    Context context;
    int resource;
    LayoutInflater vi;
    public PatientListAdapter(Context context, int resource, ArrayList<Patient> objects) {
        super(context, resource, objects);
        patientList=objects;
        this.resource=resource;
        this.context=context;
        vi=(LayoutInflater) context.getSystemService(context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        ViewHolder holder;
        if(convertView==null){
           convertView= vi.inflate(resource,null);
            holder=new ViewHolder();
            holder.tvPatientName=(TextView) convertView.findViewById(R.id.rltvPatientName);
            holder.tvState=(TextView) convertView.findViewById(R.id.rltvState);
            convertView.setTag(holder);
        } else{
            holder=(ViewHolder) convertView.getTag();
        }

        holder.tvPatientName.setText(patientList.get(position).getPatinetName());
        holder.tvState.setText("State: "+patientList.get(position).getState());

        return convertView;
    }

    static class ViewHolder{
        public TextView tvPatientName,tvState,tvData;
    }

}
