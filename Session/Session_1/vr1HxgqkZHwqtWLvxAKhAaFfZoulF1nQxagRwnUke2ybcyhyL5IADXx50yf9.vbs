set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/InterfaceLocale/Session/Session_1/vr1HxgqkZHwqtWLvxAKhAaFfZoulF1nQxagRwnUke2ybcyhyL5IADXx50yf9.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"