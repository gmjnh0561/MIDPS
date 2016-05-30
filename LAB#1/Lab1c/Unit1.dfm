object Form1: TForm1
  Left = 253
  Top = 100
  Width = 870
  Height = 640
  Caption = 'MIDPS 1-C'
  Color = clSilver
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object PaintBox1: TPaintBox
    Left = 352
    Top = 152
    Width = 465
    Height = 273
  end
  object Label1: TLabel
    Left = 256
    Top = 56
    Width = 90
    Height = 13
    Caption = 'Data si ora curenta'
  end
  object Label2: TLabel
    Left = 256
    Top = 120
    Width = 303
    Height = 18
    Caption = 'Resurse grafice ale mediului Builder C++'
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -16
    Font.Name = 'Cambria'
    Font.Style = [fsBold, fsItalic]
    ParentFont = False
    OnClick = Label2Click
  end
  object Start: TButton
    Left = 112
    Top = 176
    Width = 113
    Height = 49
    Caption = 'Start'
    TabOrder = 0
    OnClick = StartClick
  end
  object Stop: TButton
    Left = 112
    Top = 232
    Width = 113
    Height = 49
    Caption = 'Stop'
    TabOrder = 1
    OnClick = StopClick
  end
  object Exit: TButton
    Left = 128
    Top = 296
    Width = 75
    Height = 49
    Caption = 'Exit'
    TabOrder = 2
    OnClick = ExitClick
  end
  object Panel1: TPanel
    Left = 256
    Top = 152
    Width = 73
    Height = 273
    Color = clGreen
    TabOrder = 3
  end
  object Panel2: TPanel
    Left = 256
    Top = 152
    Width = 73
    Height = 121
    Color = clBackground
    TabOrder = 4
  end
  object Edit1: TEdit
    Left = 256
    Top = 80
    Width = 169
    Height = 21
    TabOrder = 5
  end
  object Timer1: TTimer
    OnTimer = Timer1Timer
    Left = 32
    Top = 16
  end
  object Timer2: TTimer
    Interval = 500
    OnTimer = Timer2Timer
    Left = 80
    Top = 16
  end
end
