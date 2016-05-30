//---------------------------------------------------------------------------

#include <vcl.h>
#pragma hdrstop

#include "Unit1.h"
#include "stdio.h"
#include "dos.h"
#include "stdlib.h"
//---------------------------------------------------------------------------
#pragma package(smart_init)
#pragma resource "*.dfm"
TForm1 *Form1;

struct date d;
struct time t;

int cordx = 0;

//---------------------------------------------------------------------------
__fastcall TForm1::TForm1(TComponent* Owner)
        : TForm(Owner)
{
        Edit1->Clear();
        Timer2->Enabled = false;
}
//---------------------------------------------------------------------------

void __fastcall TForm1::ExitClick(TObject *Sender)
{
        Close();
}
//---------------------------------------------------------------------------

void __fastcall TForm1::Timer1Timer(TObject *Sender)
{
        char buf[20];
        getdate(&d);
        gettime(&t);
        sprintf(buf,"%02d-%02d-%4d %02d:%02d:%02d",d.da_day,d.da_mon,d.da_year,
        t.ti_hour,t.ti_min,t.ti_sec);
        Edit1->Text = (AnsiString)buf;
}
//---------------------------------------------------------------------------

void __fastcall TForm1::StartClick(TObject *Sender)
{
        Timer2->Enabled = true;        
}
//---------------------------------------------------------------------------
void __fastcall TForm1::StopClick(TObject *Sender)
{
        Timer2->Enabled = false;        
}
//---------------------------------------------------------------------------
void __fastcall TForm1::Timer2Timer(TObject *Sender)
{
        PaintBox1->Canvas->Brush->Color = clGray;
        PaintBox1->Canvas->Pen->Color = clGray;
        PaintBox1->Canvas->Brush->Style = bsCross;
        PaintBox1->Canvas->Rectangle(0,0,PaintBox1->Width,PaintBox1->Height);
        PaintBox1->Canvas->FloodFill(PaintBox1->Left+5,PaintBox1->Top+5,clBlack,fsBorder);

        Panel2->Height = rand() % 150 + 50;
        PaintBox1->Canvas->Pen->Color=clLime;
        PaintBox1->Canvas->Pen->Width = 1;

        PaintBox1->Canvas->LineTo(cordx,rand() % 150 + 50);
        cordx += 10;
        if(cordx > PaintBox1->Width){
                cordx = 0;
                PaintBox1->Canvas->MoveTo(0,150);
                PaintBox1->Repaint();
        }

}
