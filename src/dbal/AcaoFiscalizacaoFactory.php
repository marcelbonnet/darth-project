<?php
namespace Darth\Core\dbal;

abstract class AcaoFiscalizacaoFactory
{

    const SSF_FACTORY = 2;
    const FOCUS_FACTORY = 4;

    /**
    * Description
    * 
    * @param Type name description
    * @throws Type
    * @return AcaoFiscalizacaoFactory instância ou null se não houver factory
    */
    public static getAcaoFiscalizacaoFactory(int which) #:AcaoFiscalizacaoFactory
    {
        switch (which) {
            case self::SSF_FACTORY;
                #return instância registrada de mod SSF, implements ISsf...
                return SsfDataSource::getInstance();
            break;

            case self::FOCUS_FACTORY;
                #return instância registrada de mod FOCUS, implements IFocus...
                return FocusDataSource::getInstance();
            break;
        
            default :
                return null;
            break;
        }
        
    }

    #public abstract function getDataSource();  #: ISsfDataSource

    #public abstract function getFocusDataSource(); #: ISsfFocusDataSource

}
