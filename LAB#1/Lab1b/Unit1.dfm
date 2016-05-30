object Form1: TForm1
  Left = 296
  Top = 306
  Width = 390
  Height = 167
  Caption = 'Vasile Buldumac Lab1 (B)'
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object Label1: TLabel
    Left = 104
    Top = 8
    Width = 32
    Height = 13
    Caption = 'Label1'
  end
  object Label2: TLabel
    Left = 104
    Top = 64
    Width = 32
    Height = 13
    Caption = 'Label2'
  end
  object Start: TButton
    Left = 288
    Top = 32
    Width = 65
    Height = 25
    Caption = 'Incepe'
    TabOrder = 0
    OnClick = StartClick
  end
  object Stop: TButton
    Left = 288
    Top = 88
    Width = 65
    Height = 25
    Caption = 'Opreste'
    TabOrder = 1
    OnClick = StopClick
  end
  object Zero: TButton
    Left = 8
    Top = 40
    Width = 73
    Height = 25
    Caption = 'Zero'
    TabOrder = 2
    OnClick = ZeroClick
  end
  object Edit1: TEdit
    Left = 104
    Top = 88
    Width = 161
    Height = 21
    TabOrder = 3
    Text = 'Timerul'
  end
  object Edit2: TEdit
    Left = 104
    Top = 32
    Width = 161
    Height = 21
    TabOrder = 4
    Text = 'Timpul'
  end
  object Exit: TButton
    Left = 8
    Top = 80
    Width = 73
    Height = 41
    Caption = 'Iesire'
    TabOrder = 5
    OnClick = ExitClick
  end
  object Timer1: TTimer
    Interval = 100
    OnTimer = Timer1Timer
    Left = 48
  end
  object Timer2: TTimer
    OnTimer = Timer2Timer
    Left = 16
  end
end
