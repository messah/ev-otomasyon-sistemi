package ev.otomasyon.sistemi;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class main extends Activity {
    /** Called when the activity is first created. */
	
	//WebView tanımlaması
	WebView mWebView;
	String DEFAULT_URL = "http://m.messah.net";
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main );
         
         //Sayfalar arası geçişlerin android içinde olması için WebViewClient kullanımı
         WebViewClient yourWebClient = new WebViewClient()
         {
             @Override
             public boolean shouldOverrideUrlLoading(WebView  view, String  url)
             {
             
              //if ( url.contains("http://m.messah.net") == true )
              if ( url.contains("http://") == true )
                
                 return false;                         
           
              DEFAULT_URL = url;
              return true;
             }
         };
         
         mWebView = (WebView) findViewById( R.id.webview );
         mWebView.getSettings().setJavaScriptEnabled(true);   
         mWebView.getSettings().setSupportZoom(true);   
         mWebView.getSettings().setBuiltInZoomControls(true);
         mWebView.setWebViewClient(yourWebClient);

         //mWebView.loadUrl("http://m.messah.net");
         mWebView.loadUrl(DEFAULT_URL);
          
     }
     
    //Menü tanımlaması
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.anamenu,menu);
        return super .onCreateOptionsMenu(menu);
    }
        
    //Menüde bulunacak seçeneklerin tanımlanması
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
        	//Yenileme
        	case R.id.item1:
        			mWebView.loadUrl("http://m.messah.net/user/yenile.php");
        			return true;
        	//İletişim
            case R.id.item2:
            	mWebView.loadUrl("http://m.messah.net/iletisim.php");
                return true;
            //Çıkış
            case R.id.item3:
            	Intent intent = new Intent(Intent.ACTION_MAIN);
            	intent.addCategory(Intent.CATEGORY_HOME);
            	intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            	intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            	startActivity(intent);
            	System.exit(0);
                return true;
                
            default:
                return super.onOptionsItemSelected(item);                
        }
    }
    
    //Geri tuşunun aktif edilmesi
    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if ((keyCode == KeyEvent.KEYCODE_BACK) && mWebView.canGoBack()) {
        	if (mWebView.getUrl().equals("http://m.messah.net/iletisim.php")) {
        		mWebView.goBack();
                return false;
        	}
        	moveTaskToBack(true);
            return false;
        }
        return super.onKeyDown(keyCode, event);
    }
}