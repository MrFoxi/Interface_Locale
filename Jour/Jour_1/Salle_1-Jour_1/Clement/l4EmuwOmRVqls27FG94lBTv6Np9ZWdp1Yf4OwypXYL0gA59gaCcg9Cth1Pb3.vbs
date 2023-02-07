set shell = CreateObject("WScript.Shell")
                        shell.SendKeys "^{PGUP}"
                        WScript.Sleep 1000
                        shell.SendKeys "{ESC}"
                        shell.Run("C:/wamp64/www/InterfaceLocale/Jour/$nom_jour[0]/$nom_salle/$nom_session/l4EmuwOmRVqls27FG94lBTv6Np9ZWdp1Yf4OwypXYL0gA59gaCcg9Cth1Pb3.pptx")
                        WScript.Sleep 7000
                        shell.SendKeys "{F5}"