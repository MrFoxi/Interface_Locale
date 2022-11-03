set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/InterfaceLocale/Session/Session_4/3GMCyx2uNWSu0oxUfaMZq3mAKDGodhI87SyVA3xPxbk6EWihagF71qSwBOud.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"