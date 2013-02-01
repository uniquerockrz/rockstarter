<?php require_once "qcubed/qcubed.inc.php";
class EmailForm extends QForm{
    protected $email;
    protected $txtBox1;
    protected $btnSubmit;
    protected $lblMsg;
    protected $lblMsg1;

    protected function Form_Create(){
        $this->lblMsg = new QLabel($this);
        $this->lblMsg->Visible = false;
        $this->lblMsg1 = new QLabel($this);
        $this->lblMsg1->Visible = false;
        $this->txtBox1 = new QTextBox($this);
        $this->txtBox1->SetCustomAttribute('placeholder', 'you@domain.com');
        $this->btnSubmit = new QButton($this);
        $this->btnSubmit->Text = "Submit";
        $this->btnSubmit->CssClass = "btn-primary";
        $this->btnSubmit->CausesValidation = true;
        $this->btnSubmit->AddAction(new QClickEvent(), new QAjaxAction('btn_click'));
    }
    protected function btn_click($strFormId, $strControlId, $strParameter){
        $objEmail = new Starter;
        $objEmail->Email = $this->txtBox1->Text;
        $objEmail->Save();
        $this->lblMsg->Visible = false;
        $this->lblMsg1->Text = "Done! Thanks For Registering";
        $this->lblMsg1->Visible = true;
    }
    protected function Form_Validate(){
        $objEmail = Starter::LoadByEmail($this->txtBox1->Text);
        if($objEmail!=null){
            $this->lblMsg->Text = "Email Already Registered";
            $this->lblMsg->Visible = true;
            return false;
        }
        else if($this->txtBox1->Text == null){
            $this->lblMsg->Text = "Please Enter Email";
            $this->lblMsg->Visible = true;
            return false;
        }
        $i=0;
        $isEmail=false;
        $str=$this->txtBox1->Text;
        while($i<strlen($str)){
            if($str{$i}=='@'){
                $isEmail=true;
            }
            $i++;
        }
        if($isEmail==false){
            $this->lblMsg->Text = "Enter Email In Correct Format";
            $this->lblMsg->Visible = true;
            return false;
        }
        return true;
    }
}
EmailForm::Run('EmailForm')
?>
