set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/InterfaceLocale/Session/Session_6/TxtJDMMsKLKk4v1CRkUFrhnDtejCwtYibr54d6grFestRDGnE3bFj8447RCL.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"