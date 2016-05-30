//---------------------------------------------------------------------------

#ifndef Unit1H
#define Unit1H
//---------------------------------------------------------------------------
#include <Classes.hpp>
#include <Controls.hpp>
#include <StdCtrls.hpp>
#include <Forms.hpp>
#include <ExtCtrls.hpp>
//---------------------------------------------------------------------------
class TForm1 : public TForm
{
__published:	// IDE-managed Components
        TTimer *Timer1;
        TTimer *Timer2;
        TButton *Start;
        TButton *Stop;
        TButton *Exit;
        TPanel *Panel1;
        TPanel *Panel2;
        TEdit *Edit1;
        TPaintBox *PaintBox1;
        TLabel *Label1;
        TLabel *Label2;
        void __fastcall ExitClick(TObject *Sender);
        void __fastcall Timer1Timer(TObject *Sender);
        void __fastcall StartClick(TObject *Sender);
        void __fastcall StopClick(TObject *Sender);
        void __fastcall Timer2Timer(TObject *Sender);
        void __fastcall Label2Click(TObject *Sender);
private:	// User declarations
public:		// User declarations
        __fastcall TForm1(TComponent* Owner);
};
//---------------------------------------------------------------------------
extern PACKAGE TForm1 *Form1;
//---------------------------------------------------------------------------
#endif                                
