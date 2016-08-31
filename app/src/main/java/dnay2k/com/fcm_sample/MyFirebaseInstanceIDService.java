package dnay2k.com.fcm_sample;

import android.util.Log;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;

import java.io.IOException;

import okhttp3.FormBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;

/**
 * Created by dnay2 on 2016-07-22.
 */
public class MyFirebaseInstanceIDService extends FirebaseInstanceIdService {

    static final String TAG = "MyFirebaseIDService";

    @Override
    public void onTokenRefresh() {
        Log.d("test", "tokenrefresh");
        //Get updated InstanceID Token.
        // only First time can get token another you can't see token,
        // If you didn't see your token, i recommend delete and reinstall your app
        String refreshedToken = FirebaseInstanceId.getInstance().getToken();
        Log.d(TAG, "Refreshed token : " + refreshedToken);

        //TODO: Implement this method to send any registration to your app's servers

        sendRegistrationToServer(refreshedToken); // upload token to your server
    }

    private void sendRegistrationToServer(String token) {

        //Need Okhttp library in Gradle(level app)
        OkHttpClient client = new OkHttpClient();
        RequestBody body = new FormBody.Builder()
                .add("Token", token)
                .build();

        //request
        Log.d("Test", token);
        Request request = new Request.Builder()
                .url(""/* your server address*/)
                .post(body)
                .build();

        try {
            client.newCall(request).execute();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
