set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/InterfaceLocale/Session/Session_1/NxjOT5njE62vBoFulTM58m4qJlPNVT0U3rh0e5xzc782G3LKyvozECf3qkYA.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"