Imports System.Data

Partial Class LiveGrid
Inherits System.Web.UI.UserControl
   
' ----------------------------------------------------
' Constants
' ----------------------------------------------------

Public Const sizeToWindow=-1
Public Const sizeToData=-2
Public Const sizeToBody=-3
Public Const sizeToParent=-4

' ----------------------------------------------------
' Private Properties
' ----------------------------------------------------

Private _rows As Integer = sizeToWindow
Private _sqlQuery as string
Private _sqlFilters as New ArrayList()
Private _gridHeading As ITemplate = Nothing
Private _headingTop As ITemplate = Nothing
Private _headingBottom As ITemplate = Nothing
Protected globalInitScript as String = ""
Protected hdgCells as New ArrayList()
Protected HdgContainer As New GridContainer()
Protected DebugString As String
Protected oSqlCompat as sqlCompatibilty


' ----------------------------------------------------
' Public Properties
' ----------------------------------------------------

Public columns as New ArrayList()
Public dataProvider as String = "ricoXMLquery.aspx"
Public menuEvent as String = "dblclick"
Public frozenColumns as Integer = 0
Public canSortDefault as Boolean = True
Public canHideDefault as Boolean = True
Public canFilterDefault as Boolean = True
Public allowColResize as Boolean = True
Public highlightElem as String = "menuRow"
Public highlightMethod as String
Public prefetchBuffer as Boolean = True
Public DisplayTimer as Boolean = True
Public DisplayBookmark as Boolean = True
Public Caption as String
Public click as String
Public dblclick as String
Public contextmenu as String
Public headingSort as String
Public beforeInit as String
Public afterInit as String
Public TableFilter as String
Public FilterLocation as Integer = -2
Public FilterAllToken as String
Public FilterBoxMaxLen as Integer = -1
Public FilterAnchorLeft as Boolean = false  ' when matching text box values, should they match beginning of string (true) or anywhere in string (false)?
Public debug as Boolean = False
Public requestParameters as New Hashtable()
Public saveColumnWidth as Boolean = True
Public saveColumnFilter as Boolean = False
Public saveColumnSort as Boolean = False
Public DefaultSort as String
Public BufferType as String


Public Property rows() As Integer
  Get
    Return _rows
  End Get
  Set(ByVal Value As Integer)
    _rows=Value
  End Set
End Property

<TemplateContainer(GetType(GridContainer))> _
Public Property GridColumns() As ITemplate
  Get
    Return _gridHeading
  End Get
  Set
    _gridHeading = value
  End Set
End Property

<TemplateContainer(GetType(GridContainer))> _
Public Property HeadingTop() As ITemplate
  Get
    Return _headingTop
  End Get
  Set
    _headingTop = value
  End Set
End Property

<TemplateContainer(GetType(GridContainer))> _
Public Property HeadingBottom() As ITemplate
  Get
    Return _headingBottom
  End Get
  Set
    _headingBottom = value
  End Set
End Property

Public Property sqlQuery() As String
  Get
    Return _sqlQuery
  End Get
  Set(ByVal Value As String)
    _sqlQuery=Value
    session.contents(Me.UniqueId)=Value
    session.contents(Me.UniqueId & ".filters")=Me._sqlFilters
  End Set
End Property

Protected ReadOnly Property TimerSpan() As String
  Get
    if Me.DisplayTimer then
      Return "<span id='" & Me.UniqueId & "_timer' class='ricoSessionTimer'>&nbsp;</span>"
    else
      Return ""
    end if
  End Get
End Property

Protected ReadOnly Property BookmarkSpan() As String
  Get
    if Me.DisplayBookmark then
      Return "<span id='" & Me.UniqueId & "_bookmark'>&nbsp;</span>"
    else
      Return ""
    end if
  End Get
End Property

Protected ReadOnly Property SaveMsgSpan() As String
  Get
    if Me.formView then
      Return "<span id='" & Me.UniqueId & "_savemsg' class='ricoSaveMsg'></span>"
    else
      Return ""
    end if
  End Get
End Property

Protected ReadOnly Property CaptionSpan() As String
  Get
    if IsNothing(Caption) then
      Return ""
    else
      Return "<span id='" & Me.UniqueId & "_caption' class='ricoCaption'>" & Me.Caption & "</span>"
    end if
  End Get
End Property

Protected ReadOnly Property FilterIcon() As String
  Get
    if FilterLocation >= -1 then
      Return "<a id='ex3_filterLink' href='#' style='margin-right:1em;'></a>"
    else
      Return ""
    end if
  End Get
End Property

Protected ReadOnly Property Bookmark() As String
  Get
    if Me.DisplayBookmark or Me.DisplayTimer or not IsNothing(Caption) then
      Return "<p class='ricoBookmark'>" & Me.CaptionSpan & Me.TimerSpan & Me.FilterIcon & Me.BookmarkSpan & Me.SaveMsgSpan & "</p>"
    else
      Return ""
    end if
  End Get
End Property

Protected ReadOnly Property init_Script() As String
  Get
    Dim script as New System.Text.StringBuilder(), confirmCol as Integer=0
    script.Append("var " & Me.UniqueId & " = {};" & vbCrLf)
    script.Append("function " & Me.UniqueId & "_init" & "() {" & vbCrLf)
    if not IsNothing(beforeInit) then script.Append(beforeInit & vbCrLf)

    ' grid options

    script.Append("  " & optionsVar & " = {" & vbCrLf)
    script.Append("    visibleRows: " & Me.rows & "," & vbCrLf)
    script.Append("    frozenColumns: " & frozenColumns & "," & vbCrLf)
    script.Append("    canSortDefault: " & lcase(canSortDefault) & "," & vbCrLf)
    script.Append("    canHideDefault: " & lcase(canHideDefault) & "," & vbCrLf)
    script.Append("    canFilterDefault: " & lcase(canFilterDefault) & "," & vbCrLf)
    script.Append("    allowColResize: " & lcase(allowColResize) & "," & vbCrLf)
    script.Append("    highlightElem: '" & highlightElem & "'," & vbCrLf)
    if not IsNothing(highlightMethod) then script.Append("    highlightMethod: '" & highlightMethod & "'," & vbCrLf)
    script.Append("    prefetchBuffer: " & lcase(prefetchBuffer) & "," & vbCrLf)
    script.Append("    menuEvent: '" & menuEvent & "'," & vbCrLf)
    if not IsNothing(RecordName) then script.Append("    RecordName: '" & RecordName & "'," & vbCrLf)
    script.Append("    saveColumnInfo: {width:" & lcase(saveColumnWidth) & ", filter:" & lcase(saveColumnFilter) & ", sort:" & lcase(saveColumnSort) & "}," & vbCrLf)
    if panels.count > 0 then
      script.Append("    PanelNamesOnTabHdr: " & lcase(PanelNamesOnTabHdr) & "," & vbCrLf)
      script.Append("    panels: ['" & join(panels.ToArray(),"','") & "']," & vbCrLf)
    end if
    if not IsNothing(headingSort) then script.Append("    headingSort: '" & headingSort & "'," & vbCrLf)
    if not IsNothing(click)       then script.Append("    click: " & click & "," & vbCrLf)
    if not IsNothing(dblclick)    then script.Append("    dblclick: " & dblclick & "," & vbCrLf)
    if not IsNothing(contextmenu) then script.Append("    contextmenu: " & contextmenu & "," & vbCrLf)
    if FilterLocation >= -1       then script.Append("    FilterLocation: " & FilterLocation & "," & vbCrLf)
    if not IsNothing(FilterAllToken) then script.Append("    FilterAllToken: '" & FilterAllToken & "'," & vbCrLf)
    if FilterBoxMaxLen >= 0       then script.Append("    FilterBoxMaxLen: " & FilterBoxMaxLen & "," & vbCrLf)
    if FilterAnchorLeft           then script.Append("    FilterAnchorLeft: " & lcase(FilterAnchorLeft) & "," & vbCrLf)
    if formView then
      script.Append("    canAdd: " & lcase(canAdd) & "," & vbCrLf)
      script.Append("    canEdit: " & lcase(canEdit) & "," & vbCrLf)
      script.Append("    canClone: " & lcase(canClone) & "," & vbCrLf)
      script.Append("    canDelete: " & lcase(canDelete) & "," & vbCrLf)
      script.Append("    ConfirmDelete: " & lcase(ConfirmDelete) & "," & vbCrLf)
      script.Append("    TableSelectNew: '" & TableSelectNew & "'," & vbCrLf)
      script.Append("    TableSelectNone: '" & TableSelectNone & "'," & vbCrLf)
      if panelHeight > 0 then script.Append("    panelHeight: " & panelHeight & "," & vbCrLf)
      if panelWidth > 0 then script.Append("    panelWidth: " & panelWidth & "," & vbCrLf)
      if not IsNothing(showSaveMsg) then script.Append("    showSaveMsg: '" & showSaveMsg & "'," & vbCrLf)
    end if
    script.Append("    columnSpecs   : [" & vbCrLf)
    Dim c as Integer
    for c=0 to columns.count-1
      if c > 0 then script.Append("," & vbCrLf)
      script.Append(CType(columns(c),GridColumn).script)
      if columns(c).ConfirmDeleteColumn then confirmCol=c
    next
    script.Append("]")
    if formView then script.Append("," & vbCrLf & "ConfirmDeleteCol: " & confirmCol)
    script.Append(vbCrLf & "  }" & vbCrLf)

    ' buffer

    dim a as New ArrayList()
    script.Append("  " & bufferOptVar & " = {")
    if requestParameters.Count > 0 then
      Dim param As DictionaryEntry
      For Each param In requestParameters
        a.Add(vbCrLf & "      {name:'" & param.Key & "',value:'" & param.Value & "'}")
      Next
      script.Append(vbCrLf & "    requestParameters: [" & String.Join(",", a.ToArray(Type.GetType("System.String"))) & vbCrLf & "    ]")
    end if
    if BufferType="AjaxSQL" then
      if a.Count > 0 then script.Append(",")
      script.Append(vbCrLf & "    TimeOut: " & Session.Timeout)
    end if
    script.Append(vbCrLf & "  }" & vbCrLf)
    script.Append("  " & bufferVar & " = new Rico.Buffer." & BufferType & "('" & dataProvider & "', " & bufferOptVar & ");" & vbCrLf)

    ' grid

    script.Append("  " & gridVar & " = new Rico.LiveGrid ('" & Me.UniqueId & "', " & bufferVar & ", " & optionsVar & ");" & vbCrLf)
    if not IsNothing(menuEvent) then
      script.Append("  " & gridVar & ".menu = new Rico.GridMenu({ menuEvent : '" & menuEvent & "'});" & vbCrLf)
    end if

    ' form

    if formView then
      script.Append("  if(typeof " & Me.UniqueId & "_FormInit=='function') " & Me.UniqueId & "_FormInit();" & vbCrLf)
      script.Append("  " & formVar & "=new Rico.TableEdit(" & gridVar & ");" & vbCrLf)
    end if

    script.Append("  if(typeof " & Me.UniqueId & "_InitComplete=='function') " & Me.UniqueId & "_InitComplete();" & vbCrLf)
    if not IsNothing(afterInit) then script.Append(afterInit & vbCrLf)

    script.Append("}" & vbCrLf)
    Return script.ToString
  End Get
End Property


' ----------------------------------------------------
' Properties for LiveGridForms
' ----------------------------------------------------

Public dbConnection as object
Public formView as Boolean = false
Public TableSelectNew as String = "___new___"
Public TableSelectNone as String = ""
Public canAdd as Boolean = true
Public canEdit as Boolean = true
Public canClone as Boolean = false
Public canDelete as Boolean = true
Public ConfirmDelete as Boolean = true
Public RecordName as String
Public PanelNamesOnTabHdr as Boolean = true
Public showSaveMsg as String
Public dbDialect as String
Public panels as New ArrayList()
Public panelHeight as Integer = -1
Public panelWidth as Integer = -1

Public gridVar as String
Public formVar as String
Public bufferVar as String
Public bufferOptVar as String ' name of buffer options js var
Public optionsVar as String   ' name of grid options js var

Protected Tables as New ArrayList()
Protected _action As String
Protected MainTbl as Integer = -1


Public Property TableName() As String
  Get
    if MainTbl >= 0 then
      Return Tables(MainTbl).TblName
    else
      Return Nothing
    end if
  End Get
  Set
    MainTbl=Tables.Count
    dim tab as new TableEditTable()
    tab.TblName=value
    tab.TblAlias="t"
    Tables.Add(tab)
  End Set
End Property

Public ReadOnly Property action() As String
  Get
    Return _action
  End Get
End Property

Public ReadOnly Property CurrentField() As GridColumn
  Get
    Return columns(columns.count-1)
  End Get
End Property

Protected Class TableEditTable
  Public TblName as String
  Public TblAlias as String
  Public arFields as New ArrayList()
  Public arData as New ArrayList()
  Public arColInfo as New ArrayList()
end class


' ----------------------------------------------------
' Methods
' ----------------------------------------------------
Sub Page_Init()
  formVar=Me.UniqueId & "['edit']"
  gridVar=Me.UniqueId & "['grid']"
  bufferVar=Me.UniqueId & "['buffer']"
  bufferOptVar=Me.UniqueId & "['bufferopt']"
  optionsVar=Me.UniqueId & "['options']"
  dim actionparm as String=Me.UniqueId & "__action"
  _action=trim(Request.QueryString(actionparm))
  if _action="" then _action=trim(Request.Form(actionparm))
  if _action="" then _action="table" else _action=lcase(_action)

  If Not (_gridHeading Is Nothing) Then
    _gridHeading.InstantiateIn(HdgContainer)
    For Each ctrl As Control In HdgContainer.Controls
      If TypeOf(ctrl) is GridColumn then
        Dim cell as New TableHeaderCell()
        cell.Text=CType(ctrl,GridColumn).Heading
        LiveGridHeadingsMain.Controls.Add(cell)
        CType(ctrl,GridColumn).panelIdx=panels.count-1
        CType(ctrl,GridColumn).FieldName=ExtFieldId(columns.count)
        columns.Add(ctrl)
        hdgCells.Add(cell)
      ElseIf TypeOf(ctrl) is GridPanel then
        panels.Add(CType(ctrl,GridPanel).heading)
      end if
    Next
  End If

  If Not (_headingTop Is Nothing) Then
    Dim container As New GridContainer()
    _headingTop.InstantiateIn(container)
    LiveGridHeadingsTop.Controls.Add(container)
  End If
  
  If Not (_headingBottom Is Nothing) Then
    Dim container As New GridContainer()
    _headingBottom.InstantiateIn(container)
    LiveGridHeadingsBottom.Controls.Add(container)
  End If
End Sub


Private Function IsFieldName(s)
  dim i,c
  i=1
  IsFieldName=false
  while i <= len(s)
    c=mid(s,i,1)
    if (c >= "0" and c <= "9" and i > 1) or (c >= "A" and c <= "Z") or (c >= "a" and c <= "z") or (c = "_") then
      i=i+1
    else
      exit function
    end if
  end while
  IsFieldName=(i > 1)
End Function


' name used external to this script
Private function ExtFieldId(i)
  ExtFieldId=Me.UniqueId & "_" & i
end function


Private function FormatValue(v as String, ByVal ColIdx as Integer) as String
  dim addquotes as Boolean = columns(ColIdx).AddQuotes
  select case left(columns(ColIdx).EntryType,1)
    case "I","F":
      addquotes=false
      if not IsNumeric(v) then v=""
    case "N":
      if v=TableSelectNew then
        v=trim(Request.Form("textnew__" & ExtFieldId(ColIdx)))
      elseif v=TableSelectNone then
        v=""
      end if
    case "S","R":
      if v=TableSelectNone then v=""
  end select
  if v="" and columns(ColIdx).isNullable then
    FormatValue="NULL"
  else
    if addquotes then v=oSqlCompat.addQuotes(v)
    FormatValue=v
  end if
end function


Private function FormatFormValue(idx as Integer) as String
  dim v as String
  if IsNothing(columns(idx).EntryType) then exit function
  if columns(idx).EntryType="H" or columns(idx).FormView="exclude" then
    v=columns(idx).ColData
  else
    v=trim(Request.Form(ExtFieldId(idx)))
  end if
  FormatFormValue=FormatValue(v,idx)
end function


' if AltTable has a multi-column key, then add those additional constraints
Private Sub AltTableKeyWhereClause(oParse as sqlParse, AltTabIdx as Integer)
  dim i as Integer
  for i=0 to ubound(Tables(AltTabIdx).arFields)
    if Tables(AltTabIdx).arColInfo(i).isKey then
      oParse.AddWhereCondition(Tables(AltTabIdx).arFields(i) & "=" & Tables(AltTabIdx).arData(i))
    end if
  next
End Sub


Private Sub AltTableJoinClause(oParse as sqlParse, TblAlias as String)
  dim i as Integer
  for i=0 to columns.Count-1
    if columns(i).TableIdx=MainTbl and IsNothing(columns(i).Formula) then
      if columns(i).isKey then oParse.AddWhereCondition(columns(i).ColName & "=" & TblAlias & "." & columns(i).ColName)
    end if
  next
End Sub


' -------------------------------------------------------------
' Add a condition to a where or having clause
' -------------------------------------------------------------
Public Sub AddCondition(ByRef WhereClause as String, ByVal NewCondition as String)
  if IsNothing(NewCondition) then exit sub
  If IsNothing(WhereClause) Then
    WhereClause = "(" & NewCondition & ")"
  Else
    WhereClause &= " AND (" & NewCondition & ")"
  End If
End Sub


' -------------------------------------------------------------
' Return the index of a column based on its column name
' -------------------------------------------------------------
Public Function ColIndex(ByVal SearchName as String)
  dim i as Integer
  for i=0 to columns.Count-1
    if columns(i).ColName=SearchName then
      ColIndex=i
      Exit Function
    end if
  next
End Function


' -------------------------------------------------------------
' Return the index of the new filter
' -------------------------------------------------------------
Public Function AddFilter(ByVal newfilter as String)
  AddFilter=_sqlFilters.Count
  _sqlFilters.Add(newfilter)
End Function


' form where clause based on table's primary key
Private function TableKeyWhereClause() as String
  dim i as Integer, w as String
  for i=0 to columns.Count-1
    if columns(i).TableIdx=MainTbl and IsNothing(columns(i).Formula) and columns(i).isKey then
      AddCondition(w, columns(i).ColName & "=" & FormatValue(trim(Request.Form("_k" & i)),i))
    end if
  next
  if IsNothing(w) then
    'Throw New Exception("no key value")
  else
    TableKeyWhereClause=" WHERE " & w
  end if
end function


Protected Sub GetColumnInfo()
  dim t as Integer, r as Integer, c as Integer, colname as String, schemaTable As DataTable
  Dim restrictions(3) As String
  if IsNothing(Me.dbConnection) then exit sub
  for t=0 to Tables.Count-1
    if debug then DebugString &= "<p>Table: " & Tables(t).TblName & " tblidx=" & t & " colcnt=" & columns.Count

    Dim command = Me.dbConnection.CreateCommand()
    command.CommandText = "select * from " & Tables(t).TblName
    dim rdr = command.ExecuteReader(CommandBehavior.KeyInfo or CommandBehavior.SchemaOnly)
    schemaTable = rdr.GetSchemaTable()
    For Each colinfo As DataRow In schemaTable.Rows
      colname = colinfo("ColumnName").ToString
      for c=0 to columns.Count-1
        if t=columns(c).TableIdx and colname=columns(c).ColName then
          with columns(c)
            .isNullable=CBool(colinfo("AllowDBNull"))
            .TypeName=replace(colinfo("DataType").ToString(),"System.","")
            if .TypeName<>"String" AndAlso not IsDBNull(colinfo("NumericPrecision")) AndAlso colinfo("NumericPrecision")<>0 then
              .Length=colinfo("NumericPrecision")
            elseif not IsDBNull(colinfo("ColumnSize")) then
              .Length=colinfo("ColumnSize")
            end if
            .Writeable=not colinfo("IsReadOnly")
            .isKey=colinfo("IsKey")
            'columns(c).FixedLength=((colinfo("COLUMN_FLAGS") and &H0000010) <> 0)
            if debug then DebugString &= "<br> Column: " & colname & " type=" & .TypeName & " len=" & .Length & " nullable=" & .isNullable & " isKey=" & .isKey
          end with
          exit for
        end if
      next
    Next
    rdr.Close()
    
    ' AllowDBNull is not accurate when using Jet driver
    if InStr(Me.dbConnection.ConnectionString,"Microsoft.Jet") > 0 then
      restrictions(2)=Tables(t).TblName
      schemaTable = Me.dbConnection.GetSchema("Columns",restrictions)
      For Each colinfo As DataRow In schemaTable.Rows
        colname = colinfo("column_name").ToString
        for c=0 to columns.Count-1
          if t=columns(c).TableIdx and colname=columns(c).ColName then
            with columns(c)
              .isNullable=CBool(colinfo("is_nullable"))
              if debug then DebugString &= "<br> Column: " & colname & " nullable=" & .isNullable
            end with
            exit for
          end if
        next
      Next
    end if
  Next
End Sub


Protected Function UpdateDatabase(sqltext as String, actiontxt as String) as String
  dim cnt as Integer
  if IsNothing(Me.dbConnection) then
    UpdateDatabase="<p>ERROR: no database connection</p>"
  else
    Try
      Dim command = Me.dbConnection.CreateCommand()
      command.CommandText = sqltext
      cnt=command.ExecuteNonQuery()
      UpdateDatabase="<p class='ricoFormResponse " & actiontxt & "Successfully'></p>"
    Catch ex As Exception
      UpdateDatabase="<p>ERROR: unable to update database - " & server.HTMLencode(ex.Message.ToString()) & "</p>"
    End Try
    'if debug then msg &= " - " & sqltext & " - Records affected: " & cnt
  end if
End Function


Public Sub DeleteRecord(writer as HTMLTextWriter)
  dim sqltext as String = "DELETE FROM " & Tables(MainTbl).TblName & TableKeyWhereClause()
  writer.WriteLine(UpdateDatabase(sqltext, "deleted"))
End Sub


Public Sub InsertRecord(writer as HTMLTextWriter)
  dim i as Integer, keyIdx as Integer
  dim keyCnt as Integer=0
  dim sqlcol as String=""
  dim sqlval as String=""
  for i=0 to columns.Count-1
    if IsNothing(columns(i).Formula) and columns(i).TableIdx=MainTbl and columns(i).UpdateOnly=false then
      if columns(i).isKey then
        keyCnt=keyCnt+1
        keyIdx=i
      end if
      if columns(i).Writeable then
        sqlcol &= "," & columns(i).ColName
        sqlval &= "," & FormatFormValue(i)
      end if
    end if
  next
  if IsNothing(sqlcol) then
    writer.WriteLine("<p>Nothing to add</p>")
  else
    dim sqltext as String="insert into " & Tables(MainTbl).TblName & " (" & mid(sqlcol,2) & ") values (" & mid(sqlval,2) & ")"
    writer.WriteLine(UpdateDatabase(sqltext, "added"))
    if Tables.Count>1 then
      if keyCnt=1 AndAlso columns(keyIdx).Writeable=false then
        ' retrieve new identity key value for UpdateAltTableRecords()
        ' currently this is sql server specific
        'if not objDB.SingleRecordQuery("SELECT SCOPE_IDENTITY()",columns(keyIdx).ColData) then
        '  Throw New Exception("unable to retrieve new identity value")
        'end if
      end if
      for i=0 to Tables.Count-1
        'if i<>MainTbl then UpdateAltTableRecords(i)
      next
    end if
  end if
End Sub


Public Sub UpdateRecord(writer as HTMLTextWriter)
  dim i as Integer, sqltext as String
  for i=0 to Tables.Count-1
    'if i<>MainTbl then UpdateAltTableRecords(i)
  next
  for i=0 to columns.Count-1
    if IsNothing(columns(i).Formula) and columns(i).TableIdx=MainTbl and columns(i).Writeable and columns(i).InsertOnly=false then
      sqltext &= "," & columns(i).ColName & "=" & FormatFormValue(i)
    end if
  next
  if IsNothing(sqltext) then
    writer.WriteLine("<p>Nothing to update</p>")
  else
    sqltext="UPDATE " & Tables(MainTbl).TblName & " SET " & mid(sqltext,2) & TableKeyWhereClause()
    writer.WriteLine(UpdateDatabase(sqltext, "updated"))
  end if
End Sub


' -------------------------------------
' form main sql query to populate the grid
' -------------------------------------
Protected Sub FormSqlQuery()
  Dim oParseMain=new sqlParse
  Dim oParseLookup=new sqlParse
  Dim oParseSubQry=new sqlParse
  Dim i as Integer
  Dim s as String
  Dim tabidx as Integer
  Dim csvPrimaryKey as String
  if debug then DebugString &= "<p>FormSqlQuery"
  oParseMain.FromClause=Tables(MainTbl).TblName & " t"
  oParseMain.AddWhereCondition(TableFilter)
  for i=0 to columns.Count-1
    if columns(i).TableIdx>=0 then tabidx=columns(i).TableIdx
    if columns(i).FilterFlag then
      ' add any column filters to where clause
      oParseMain.AddWhereCondition(columns(i).ColName & "='" & columns(i).ColData & "'")
    end if
    if not IsNothing(columns(i).EntryType) then
      Dim SessionColId as String = ExtFieldId(i)
      if InStr("CSNR",left(columns(i).EntryType,1)) > 0 then
        if not IsNothing(columns(i).SelectSql) then
          s=columns(i).SelectSql
          if not IsNothing(columns(i).SelectFilter) then
            oParseLookup.ParseSelect(s)
            oParseLookup.AddWhereCondition(columns(i).SelectFilter)
            s=oParseLookup.UnparseSelect
          end if
          session.contents(SessionColId)=replace(replace(s,"%alias%",""),"%aliasmain%","")
        else
          session.contents(SessionColId)="select distinct " & columns(i).ColName & " from " & Tables(tabidx).TblName & " where " & columns(i).ColName & " is not null"
        end if
        if debug then DebugString &= "<br> SelectSql: " & SessionColId & " " & columns(i).EntryType & " " & session.contents(SessionColId)
      end if
    end if

    if not IsNothing(columns(i).Formula) then

      ' computed column

      oParseMain.AddColumn("(" & columns(i).Formula & ")", "rico_col" & i)

    elseif tabidx=MainTbl then

      ' column from main table - avoid subqueries to make it compatible with MS Access & MySQL < v4.1

      if columns(i).isKey then
        if not IsNothing(csvPrimaryKey) then csvPrimaryKey &= ","
        csvPrimaryKey &= Tables(MainTbl).TblAlias & "." & columns(i).ColName
      end if
      if mid(columns(i).EntryType,2)="L" and not IsNothing(columns(i).SelectSql) then
        Dim TblAlias as String="t" & CStr(i)
        s=replace(columns(i).SelectSql,"%alias%",TblAlias & ".")
        oParseLookup.ParseSelect(s)
        if oParseLookup.SelectList.count=2 then
          Dim codeField as String=oParseLookup.SelectList(0).sql
          Dim descField as String=oParseLookup.SelectList(1).sql
          If IsFieldName(descField) Then
            descField=TblAlias & "." & descField
          Else
            descField=replace(replace(descField,"%alias%",TblAlias & "."),"%aliasmain%","t.")
          End If
          oParseMain.AddJoin("left join " & oParseLookup.FromClause & " " & TblAlias & _
            " on t." & columns(i).ColName & "=" & TblAlias & "." & replace(replace(codeField,"%alias%",""),"%aliasmain%",""))
          oParseMain.AddColumn(oSqlCompat.concat(new String() {descField,"'<span class=""ricoLookup"">'",oSqlCompat.Convert2Char(Tables(MainTbl).TblAlias & "." & columns(i).ColName),"'</span>'"}, false), "rico_col" & i)
        else
          Throw New Exception("Invalid lookup query (" & columns(i).SelectSql & ")")
        end if
      else
        oParseMain.AddColumn(Tables(MainTbl).TblAlias & "." & columns(i).ColName)
      end if

    else

      ' column from alt table - no avoiding subqueries here

      oParseSubQry.Init()
      oParseSubQry.AddColumn(columns(i).ColName)
      oParseSubQry.FromClause=Tables(tabidx).TblName & " a" & i
      AltTableJoinClause(oParseSubQry,"t")
      AltTableKeyWhereClause(oParseSubQry,tabidx)
      s=oParseSubQry.UnparseSelect
      if mid(columns(i).EntryType,2)="L" and not IsNothing(columns(i).SelectSql) then
        oParseLookup.ParseSelect(columns(i).SelectSql)
        if oParseLookup.SelectList.count=2 then
          Dim descQuery as String="select " & oParseLookup.SelectList(1).sql & " from " & oParseLookup.FromClause & " where " & oParseLookup.SelectList(0).sql & "=" & s
          if not IsNothing(oParseLookup.WhereClause) then descQuery=descQuery & " and " & oParseLookup.WhereClause
          oParseMain.AddColumn("(" & oSqlCompat.concat(new String() {"(" & descQuery & ")","'<span class=""ricoLookup"">'",oSqlCompat.Convert2Char(s),"'</span>'"}, false) & ")", "rico_col" & i)
        else
          Throw New Exception("Invalid lookup query (" & columns(i)("SelectSql") & ")")
        end if
      else
        oParseMain.AddColumn(s, "rico_col" & i)
      end if

    end if
  next
  if not IsNothing(DefaultSort) then
    oParseMain.AddSort(DefaultSort)
  elseif not IsNothing(csvPrimaryKey) then
    oParseMain.AddSort(csvPrimaryKey)
  end if
  Me.sqlQuery=oParseMain.UnparseSelect
End Sub


Protected Overrides Sub OnPreRender(ByVal e As System.EventArgs)    
  MyBase.OnPreRender(e)
  if not IsNothing(dbConnection) then
    oSqlCompat=New sqlCompatibilty(dbDialect)
  end if
  
  ' Fix frozen headings
  Dim i as Integer
  for i=0 to frozenColumns-1
    hdgCells(i).CssClass="ricoFrozen"
  next
  
  if IsNothing(BufferType) then
    if not IsNothing(_sqlQuery) or Tables.count > 0 then
      BufferType="AjaxSQL"
    else
      BufferType="AjaxXML"
    end if
  end if
  if BufferType="AjaxXML" then Me.DisplayTimer=false
  if IsNothing(_sqlQuery) and Tables.count > 0 then
    ' LiveGrid Forms
    Me.GetColumnInfo()
    if _action="table" then Me.FormSqlQuery()
  end if

  ' populate globalInitScript
  Dim tmpscript as String = ""
  If Not Page.IsStartupScriptRegistered("LiveGridInit") Then
    globalInitScript  = "Rico.loadModule('LiveGridAjax','LiveGridMenu');" & vbCrLf
    if formView then globalInitScript &= "Rico.loadModule('LiveGridForms');" & vbCrLf
    if FilterLocation >= -1 then globalInitScript &= "Rico.loadModule('Effect');" & vbCrLf
    globalInitScript &= "Rico.acceptLanguage('" & Request.ServerVariables("HTTP_ACCEPT_LANGUAGE") & "');" & vbCrLf
    globalInitScript &= "Rico.onLoad( function() {" & vbCrLf
    For Each ctrl As Control In Page.Controls
      If TypeOf(ctrl) is LiveGrid then
        if CType(ctrl,LiveGrid).Rows >= 0 then
          ' initialize grids with fixed # of rows first
          globalInitScript &= "  " & ctrl.UniqueId & "_init" & "();" & vbCrLf
        else
          tmpscript &= "  " & ctrl.UniqueId & "_init" & "();" & vbCrLf
        end if
      End If
    Next
    globalInitScript &= tmpscript & "});" & vbCrLf
    Page.RegisterStartupScript("LiveGridInit", "")
  End If
End Sub


Public Class GridContainer
  Inherits Control
  Implements INamingContainer
End Class

End Class
