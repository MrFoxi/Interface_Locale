set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/test/pages/InterfaceLocale/DossierPresentations/.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"