set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:/wamp64/www/InterfaceLocale/Session/Session_5/4YcPfdPxaN0nv8rOyQ9Ef8z4DvEHNCeGrF7URU7XZiYdb3Lc0Y92IciyUVkd.pptx")
WScript.Sleep 7000
shell.SendKeys "{F5}"