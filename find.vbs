Set objWMIService = GetObject("winmgmts:\\.\root\cimv2")

Set colItems = objWMIService.ExecQuery("Select * From Win32_Process where name='python.exe'")
For Each objItem in colItems
    'Wscript.Echo objItem.name & " " & objItem.ProcessID & " " & objItem.CommandLine
    Wscript.Echo objItem.ProcessID & ";" & objItem.CommandLine
Next
