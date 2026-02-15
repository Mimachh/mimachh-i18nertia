import { useTranslation } from "@/hooks/trans";
import { cn } from "@/lib/utils";
import { AppEnv } from "@/types";
import { useForm, usePage } from "@inertiajs/react";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Button } from "@/components/ui/button";
import { LucideIcon, Monitor, Moon, SettingsIcon, Sun } from "lucide-react";
import { str } from "@/lib/str";
import { Appearance, useAppearance } from "@/hooks/use-appearance";

import { FormEvent } from "react";

type Props = {
    className?: string;
}

const AppSettings = (props: Props) => {
    const { className } = props;
    const { locale, locales } = usePage().props.appEnv as AppEnv;
    const { trans } = useTranslation();
    const { post, setData } = useForm({
        locale: "system",
    });


    const { appearance, updateAppearance } = useAppearance();
    const mods: { theme: Appearance; icon: LucideIcon; name: string }[] = [
        { theme: 'light', icon: Sun, name: str(trans('global.theme_mode.light')).ucFirst().value() },
        { theme: 'dark', icon: Moon, name: str(trans('global.theme_mode.dark')).ucFirst().value() },
        { theme: 'system', icon: Monitor, name: str(trans('global.theme_mode.system')).ucFirst().value() },
    ];


    const submit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(route("change-locale"));
    };

    const languages = [
        {
            name: trans("Français"),
            locale: "fr",
            flag: "fr",
        },
        {
            name: trans("English"),
            locale: "en",
            flag: "us",
        },
        {
            name: trans("Spain"),
            locale: "es",
            flag: "es",
        },
        {
            name: trans("Germany"),
            locale: "de",
            flag: "de",
        },
    ];
    const allowedLocales = languages.filter(language => locales.includes(language.locale));
    return (
        <div className={cn(className)}>
            <DropdownMenu>
                <DropdownMenuTrigger asChild>
                    <Button className="text-muted-foreground" variant="ghost">
                        <SettingsIcon className="h-[1.2rem] w-[1.2rem]" />
                        <span className="hidden lg:block">
                            {str(trans('profile.profile_settings.settings.title')).ucFirst().value()}
                        </span>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent side="bottom" className="w-fit me-1">
                    <p className="text-center text-muted-foreground text-sm font-medium leading-7">
                        {str(trans(`profile.profile_settings.appearance.title`))
                            .ucFirst()
                            .value()}
                    </p>
                    <div className="flex flex-row justify-center items-center gap-1">
                        {mods.map((mod) => {
                            return (
                                <DropdownMenuItem
                                    key={mod.name}
                                    className="p-0"
                                    onSelect={(e) => e.preventDefault()}
                                >
                                    <Button
                                        className={cn("w-full", {
                                            "bg-secondary": appearance === mod.theme,
                                        })}
                                        variant="ghost"
                                        onClick={() =>
                                            updateAppearance(mod.theme)
                                        }
                                    >
                                        <mod.icon />
                                        {trans(mod.name)}
                                    </Button>
                                </DropdownMenuItem>
                            );
                        })}
                    </div>
                    {allowedLocales.length > 1 && (
                        <>
                            <DropdownMenuSeparator />
                            <p className="text-center text-muted-foreground text-sm font-medium leading-7">
                                {str(trans(`profile.profile_settings.languages.title`))
                                    .ucFirst()
                                    .value()}
                            </p>
                            <form
                                className="grid grid-cols-2 justify-center items-center gap-1"
                                onSubmit={submit}
                            >
                                {allowedLocales.map((language) => {
                                    return (
                                        <DropdownMenuItem
                                            key={language.name}
                                            className="p-0"
                                            onSelect={(e) => e.preventDefault()}
                                        >
                                            <Button
                                                className={cn("w-full", {
                                                    "bg-secondary": locale === language.locale,
                                                })}
                                                variant="ghost"
                                                type="submit"
                                                onClick={() => {
                                                    setData("locale", language.locale);
                                                }}
                                            >
                                                <span className={`fi fi-${language.flag}`} />
                                                {language.name}
                                            </Button>
                                        </DropdownMenuItem>
                                    );
                                })}
                            </form>
                        </>
                    )}
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    );
};

export default AppSettings;
