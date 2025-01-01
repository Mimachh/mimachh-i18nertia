import { usePage } from "@inertiajs/react";
import { LocaleData } from "@/types/locale";

export function translation() {
  const localeData = usePage().props.localeData as LocaleData;
  const { data, global, languageCode } = localeData;

  // Fonction pour accéder à une clé de traduction, prenant en compte l'imbrication
  const getTranslation = (key: string): string | undefined => {
    // Vérifie si la clé existe dans `data` ou `global`
    return key.split('.').reduce((obj, part) => obj?.[part], data) ||
           key.split('.').reduce((obj, part) => obj?.[part], global);
  };

  // Fonction de traduction avec gestion des paramètres dynamiques
  const translate = (key: string, params: { [key: string]: string } = {}): string => {
    let translation = getTranslation(key); // On récupère la traduction via la clé

    if (!translation) {
      return key; // Si la traduction n'existe pas, on retourne la clé brute
    }

    // Remplacer dynamiquement les paramètres (ex. :name, :email, etc.)
    Object.keys(params).forEach(param => {
      const regex = new RegExp(`:${param}`, 'g'); // Crée une expression régulière pour chaque param
      translation = translation?.replace(regex, params[param]);
    });

    return translation;
  };

  // Retourner les traductions et la fonction de remplacement dynamique
  return {
    data,
    global,
    languageCode,
    translate
  };
}