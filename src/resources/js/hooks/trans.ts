import { usePage } from "@inertiajs/react";
import { LocaleData, Translations } from "@/types/locale";

export function useTranslation() {
    const translations = usePage().props.translations as unknown as LocaleData;
  
    // Fonction pour accéder à une clé de traduction, prenant en compte l'imbrication
    const getTranslation = (key: string, data: Translations): string | undefined => {
      const translation = key.split('.').reduce<Translations | string>((obj, part) => {
        if (obj && typeof obj === 'object' && part in obj) {
          return obj[part]; // Si obj est de type Translations, accéder à la clé
        }
        return ''; // Retourner une chaîne vide si l'objet ou la clé n'existe pas
      }, data);
  
      return typeof translation === 'string' ? translation : undefined; // Si le résultat est une chaîne, la retourner
    };
  
    // Fonction principale de traduction
    const trans = (key: string, params: Record<string, string> = {}): string => {
      let translation = getTranslation(key, translations.translations);
  
      if (!translation) {
        return key; // Retourner la clé si la traduction n'est pas trouvée
      }
  
      // Remplacer les paramètres dans la traduction
      Object.keys(params).forEach(param => {
        const regex = new RegExp(`:${param}`, 'g');
        translation = translation?.replace(regex, params[param]);
      });
  
      return translation;
    };
  
    return {
      trans,
    };
  }