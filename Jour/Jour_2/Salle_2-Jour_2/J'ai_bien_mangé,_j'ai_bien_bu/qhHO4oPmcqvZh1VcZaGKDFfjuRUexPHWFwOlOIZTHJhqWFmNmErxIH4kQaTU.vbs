set shell = CreateObject("WScript.Shell")
                        shell.SendKeys "^{PGUP}"
                        WScript.Sleep 1000
                        shell.SendKeys "{ESC}"
                        shell.Run("C:/wamp64/www/InterfaceLocale/Jour/$nom_jour[0]/$nom_salle[0]/$nom_session/qhHO4oPmcqvZh1VcZaGKDFfjuRUexPHWFwOlOIZTHJhqWFmNmErxIH4kQaTU.pptx")
                        WScript.Sleep 7000
                        shell.SendKeys "{F5}"