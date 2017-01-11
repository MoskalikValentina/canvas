/**
 *!!! For including js files use import from es6 syntax
 */


$( document ).ready(function() {
    /** 
     *  TODO remove below. It's only for test.
     * 
     * */

    let versionJs = 'es6';
    console.log( `say Hello to ${versionJs}`);

    if(NODE_ENV == 'dev'){
        console.log('its dev mode');
    }
});