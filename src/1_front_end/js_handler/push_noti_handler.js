//Only available push notification after 2 and 1 hour of the course start

function notify_day_2_hour_delays(dateString, courseTitle) {
  // Parse the date string from MySQL into a JavaScript Date object
  const targetDate = new Date(dateString);1

  // Calculate the notification times
  const notificationTime1 = new Date(targetDate.getTime() - (2 * 60 * 60 * 1000)); // 2 hours before the target date
  const notificationTime2 = new Date(targetDate.getTime() - (1 * 60 * 60 * 1000)); // 1 hour before the target date

  // Calculate the delays until the notification times
  const delay1 = notificationTime1.getTime() - Date.now();
  const delay2 = notificationTime2.getTime() - Date.now();

  const option1 = {
    body : courseTitle + " begin in 2 hour",
  };

  const option2 = {
    body : courseTitle + " begin in 1 hour",
  };

  if (delay1 <= 0 || delay2 <= 0) {
    // The notification times have already passed, do not schedule the notifications
    return;
  }

  // Schedule the below  notification
  // 2 hour before notification 

  setTimeout(() => {
    if (!("Notification" in window)) {
      // Check if the browser supports notifications
      alert("This browser does not support desktop notification");
    } else if (Notification.permission === "granted") {
      // Check whether notification permissions have already been granted;
      const notification = new Notification("Training Reminder", option1);

    } else if (Notification.permission !== "denied") {
      // We need to ask the user for permission
      Notification.requestPermission().then((permission) => {
      
        if (permission === "granted") {
          const notification = new Notification("Training Reminder", option1);
        }
      });
    }
  }, delay1);

  // 1 hour before notification 

  setTimeout(() => {
    if (!("Notification" in window)) {
      // Check if the browser supports notifications
      alert("This browser does not support desktop notification");
    } else if (Notification.permission === "granted") {
      // Check whether notification permissions have already been granted;
      const notification = new Notification("Training Reminder", option2);

    } else if (Notification.permission !== "denied") {
      // We need to ask the user for permission
      Notification.requestPermission().then((permission) => {
        // If the user accepts, let's create a notification
        if (permission === "granted") {

          const notification = new Notification("Second Notification", option2);
        }
      });
    }
  }, delay2);
}

