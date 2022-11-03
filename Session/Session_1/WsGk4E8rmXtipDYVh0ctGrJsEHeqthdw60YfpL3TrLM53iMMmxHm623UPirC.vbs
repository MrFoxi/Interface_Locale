set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:\wamp64\www\InterfaceLocale\Session/Session_1/WsGk4E8rmXtipDYVh0ctGrJsEHeqthdw60YfpL3TrLM53iMMmxHm623UPirC.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"