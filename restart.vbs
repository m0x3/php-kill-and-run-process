Set objWMIService = GetObject("winmgmts:\\.\root\cimv2")
Set WSHELL = CreateObject("Wscript.Shell")

Set colItems = objWMIService.ExecQuery("Select * From Win32_Process where name='python.exe'")
For Each objItem in colItems
    'Wscript.Echo objItem.name & " " & objItem.ProcessID & " " & objItem.CommandLine
    'Wscript.Echo objItem.ProcessID & ";" & objItem.CommandLine
	'objItem.Terminate()
	'WScript.Echo(InStr(1, objItem.CommandLine, WScript.Arguments(1), vbTextCompare))
	If InStr(1, objItem.CommandLine, WScript.Arguments(1), vbTextCompare) Then
		objItem.Terminate()
		'WSHELL.Exec("taskkill /PID " & objItem.ProcessID & " /F")
	End If
Next

WSHELL.Exec(WScript.Arguments(0) & " " & WScript.Arguments(1))
