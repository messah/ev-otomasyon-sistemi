package ev.otomasyon.sistemi;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.os.Bundle;

//İnternet bağlantısı kontrolü
public class baglanti extends Activity{

	boolean internetBaglantisiVarMi() {
		 
        ConnectivityManager conMgr = (ConnectivityManager) getSystemService (Context.CONNECTIVITY_SERVICE);
 
        if (conMgr.getActiveNetworkInfo() != null
 
        && conMgr.getActiveNetworkInfo().isAvailable()
 
        && conMgr.getActiveNetworkInfo().isConnected()) {
 
        return true;
 
        } else {
 
        return false;
 
        }
 
    }
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		
		if(!internetBaglantisiVarMi())
        {
            AlertDialog alertDialog = new AlertDialog.Builder(this).create();
 
            alertDialog.setMessage("Uygulamayı kullanabilmek için internet bağlantınızın aktif olması gerekmektedir");
            alertDialog.setButton("Tamam", new DialogInterface.OnClickListener() {
               public void onClick(DialogInterface dialog, int which) {
                  System.exit(0);
               }
            });
 
            alertDialog.show();
        }
        else{
 
            startActivity(new Intent("ev.otomasyon.sistemi.MAIN"));
        }
		
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		
		 setContentView(R.layout.main);
		
	}

}
