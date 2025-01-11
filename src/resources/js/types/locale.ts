export interface LocaleData {
    languageCode: string;
    // data: {
    //     // [key: string]: string;
    // };
    data: any;
    global: any;
    
}

export interface Translations {
    [key: string]: string | Translations;
  }