//---------------------------------------------------------------------------

#include <vcl.h>
#pragma hdrstop

#include "Unit1.h"
#include "stdio.h"
#include "dos.h"
//---------------------------------------------------------------------------
#pragma package(smart_init)
#pragma resource "*.dfm"
TForm1 *Form1;

struct date d;
struct time t;

int zecimi = 0;
int secunde = 0;
int minute = 0;

//---------------------------------------------------------------------------
__fastcall TForm1::TForm1(TComponent* Owner)
        : TForm(Owner)
{
        Label1->Caption = "Realizarea unui cronometru in Builder C++";
        Label2->Caption = "Cronometru C++ Builder";
        Timer1->Enabled = false;
        Edit1->Clear();
        Edit2->Clear();
}
//---------------------------------------------------------------------------
void __fastcall TForm1::ExitClick(TObject *Sender)
{
        Close();        
}
//---------------------------------------------------------------------------
void __fastcall TForm1::Timer2Timer(TObject *Sender)
{
        char buf[20];
        getdate(&d);
        gettime(&t);
        sprintf(buf,"%02d-%02d-%4d %02d:%02d:%02d",d.da_day,d.da_mon,d.da_year,
        t.ti_hour,t.ti_min,t.ti_sec);
        Edit2->Text = (AnsiString)buf;

}
//---------------------------------------------------------------------------
void __fastcall TForm1::Timer1Timer(TObject *Sender)
{
        zecimi++;
        if(zecimi > 9)
        {
           secunde++;
           zecimi = 0;
        }
        if(secunde > 59)
        {
            minute++;
            secunde = 0;
        }
        char buf[20];
        sprintf(buf,"%02d:%02d:%02d",minute, secunde, zecimi);
        Edit1->Text = (AnsiString)buf;
}
//---------------------------------------------------------------------------
void __fastcall TForm1::StartClick(TObject *Sender)
{
        Timer1->Enabled = true;        
}
//---------------------------------------------------------------------------
void __fastcall TForm1::StopClick(TObject *Sender)
{
        Timer1->Enabled = false;        
}
//---------------------------------------------------------------------------
void __fastcall TForm1::ZeroClick(TObject *Sender)
{
        zecimi = 0;
        secunde = 0;
        minute = 0;
        Edit1->Text = "00:00:00";
}
//---------------------------------------------------------------------------
