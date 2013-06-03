#Exception Notifier

##Install

1. Upload the 'exception_notifier' folder in this archive to your Symphony
   'extensions' folder.
2. Update the symphony core 'symnphony/lib/core/class.log.php' (No delegates to hook info for logging, sorry) with the new function in 'class.log.php.txt'.
3. Enable extension by selecting the "Exception Notifier" item under Extensions, choose Enable
   from the with-selected menu, then click Apply.
4. In symphony preferences configure Airbrake services.

##Uninstall

1. Uninstall extension by removing the chnages to 'class.log.php.txt' and selecting the "Exception Notifier" item under Extensions, choose Uninstall from the with-selected menu, then click Apply. 
