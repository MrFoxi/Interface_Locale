set shell = CreateObject("WScript.Shell")
                        shell.SendKeys "^{PGUP}"
                        WScript.Sleep 1000
                        shell.SendKeys "{ESC}"
                        shell.Run("C:/wamp64/www/InterfaceLocale/Jour/$nom_jour[0]/$nom_salle/$nom_session/O8dZZeBrkVnBrU3VA8hNXxmSwh7dVQzYoFsTERvSKuSa5KDRYQ2Z6fzDA4iB.pptx")
                        WScript.Sleep 7000
                        shell.SendKeys "{F5}"