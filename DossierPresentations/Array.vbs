set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/test/pages/InterfaceLocale/DossierPresentations/ChBYOuf7ui2LDLR1arQvW3zJ8vGW4LCYBmlV7w34kOa0vWM61naLUAq5VTEP.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"