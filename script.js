function setTheme(theme) 
{
    if (theme == 'Padrão') 
    {
        localStorage.setItem('panelTheme', theme);
        
        document.body.style.setProperty('--cor-principal', '#49B3FF');
        document.body.style.setProperty('--cor-principal-escuro', '#3989c2');
        document.body.style.setProperty('--cor-secundaria', '#D83447');
        document.body.style.setProperty('--cor-secundaria-escuro', '#a82937');
        document.body.style.setProperty('--cor-cinza', '#868987');
        document.body.style.setProperty('--cor-branco', '#FFF');
        document.body.style.setProperty('--cor-preto', '#232626');
    }
    if (theme == 'Invertido') 
    {
        localStorage.setItem('panelTheme', theme);
        
        document.body.style.setProperty('--cor-principal', '#D83447');
        document.body.style.setProperty('--cor-principal-escuro', '#a82937');
        document.body.style.setProperty('--cor-secundaria', '#49B3FF'); 
        document.body.style.setProperty('--cor-secundaria-escuro', '#3989c2'); 
        document.body.style.setProperty('--cor-cinza', '#868987');
        document.body.style.setProperty('--cor-branco', '#232626');
        document.body.style.setProperty('--cor-preto', '#FFF');
    }
}

function loadTheme() 
{
    //Ao carregar a página se o 'panelTheme' estiver vazio coloca o tema Padrão.
    if (localStorage.getItem('panelTheme') == '') 
    {
      setTheme('Padrão');
    } 
    else 
    {
      setTheme(localStorage.getItem('panelTheme'));
    }
}