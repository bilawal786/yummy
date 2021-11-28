/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    databaseURL: "https://carwash-64763.firebaseio.com",
    apiKey: "AIzaSyC_5Wl09LtYyCVNZq9mn5A9HstB_TzCijI",
    authDomain: "carwash-64763.firebaseapp.com",
    projectId: "carwash-64763",
    storageBucket: "carwash-64763.appspot.com",
    messagingSenderId: "720025103840",
    appId: "1:720025103840:web:f5c124ff8f5095fc424f85",
    measurementId: "G-E9C01SPTJC"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});
