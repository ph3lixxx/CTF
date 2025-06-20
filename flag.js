(function() {

    // Encode flag: CYC{rwaweeeeerrrrrerrrcoolbank}

    const encodedFlag = [67,89,67,123,114,119,97,119,101,101,101,101,101,114,114,114,114,114,101,114,114,114,99,111,111,108,98,97,110,107,125];

    window.__getFlag = () => String.fromCharCode(...encodedFlag);

    

    const hint = document.createElement('div');

    hint.style.position = 'absolute';

    hint.style.top = '0';

    hint.style.left = '0';

    hint.style.width = '15px';

    hint.style.height = '15px';

    hint.title = 'console.log(__getFlag())';

    document.body.appendChild(hint);

})();
