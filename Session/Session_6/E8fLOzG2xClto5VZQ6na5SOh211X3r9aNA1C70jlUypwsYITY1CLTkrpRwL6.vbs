set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/InterfaceLocale/Session/Session_6/E8fLOzG2xClto5VZQ6na5SOh211X3r9aNA1C70jlUypwsYITY1CLTkrpRwL6.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"