set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/InterfaceLocale/Session/Session_3/j4KtAxqJzXDjSwZnXXRptMYH9XaFt6n287Jk21pjNgRIG5mHoJwYTEGyNc2H.odp")
WScript.Sleep 7000
shell.SendKeys "{F5}"