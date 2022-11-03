set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/InterfaceLocale/Session/Session_1/5QWXsqe76eCS0ua1upUwY6vdc6XwY7QFlaZC3nCcULtEKvHnltoAgFDZrtK8.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"