object Form1: TForm1
  Left = 192
  Top = 169
  Width = 696
  Height = 480
  Caption = 'Buldumac Vasile Laborator 1 (A)'
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
    Left = 176
    Top = 56
    Width = 257
    Height = 41
    Caption = 'Label1'
  end
  object Button1: TButton
    Left = 128
    Top = 120
    Width = 193
    Height = 57
    Caption = 'Incrementeaza Caseta cu 1'
    TabOrder = 0
    OnClick = Button1Click
  end
  object Button2: TButton
    Left = 128
    Top = 192
    Width = 193
    Height = 57
    Caption = 'Decrementeaza Caseta cu 1'
    TabOrder = 1
    OnClick = Button2Click
  end
  object Button3: TButton
    Left = 152
    Top = 264
    Width = 147
    Height = 49
    Caption = 'Iesire din program'
    TabOrder = 2
    OnClick = Button3Click
  end
  object Edit1: TEdit
    Left = 344
    Top = 160
    Width = 49
    Height = 41
    TabOrder = 3
    Text = 'Caseta'
  end
end
